<script>
import axios from "axios";

export default {
  template: '<slot v-bind="vm"/>',
  created() {
    this.setState("input-book");
  },
  data: function () {
    return {
      state: null,
      selectedUser: null,
      selectedBook: null,
    };
  },
  computed: {
    key: function () {
      // I dont know where tf is the key required in render...
      return "";
    },
    vm: function () {
      return this;
    },
    bookLink: function () {
      return "podrobnosti-o-knize/" + this.selectedBook?.id;
    },
    userLink: function () {
      return "detail-uzivatele/" + this.selectedUser?.id;
    },
    confirmInput: function () {
      return document.getElementById("confirmInput");
    },
    bookInput: function () {
      return document.getElementById("bookInput");
    },
    userInput: function () {
      return document.getElementById("userInput");
    },
  },
  methods: {
    showDate(date) {
      return showDate(date);
    },
    clearBook() {
      this.selectedBook = null;
      this.bookInput.value = "";
      this.updateState();
    },
    clearUser() {
      this.selectedUser = null;
      this.userInput.value = "";
      this.updateState();
    },
    setState(state) {
      let states = {
        confirm: "confirmInput",
        "input-book": "bookInput",
        "input-user": "userInput",
      };
      setTimeout(() => {
        this[states[state]].focus();
      }, 0);
      this.state = state;
    },
    updateState(send = true) {
      if (!this.selectedBook) {
        this.setState("input-book");
      } else if (this.selectedBook.is_borrowed) {
        if (!send) {
          this.setState("confirm");
        } else {
          this.selectedBook.return().then((response) => {
            if (response.data.success) {
              if(this.selectedUser) {
              this.selectedUser.activeBorrows = response.data.borrow.user?.activeBorrows;
              }
              this.clearBook();
            }
          });
        }
      } else if (!this.selectedUser) {
        this.setState("input-user");
      } else if (
        this.selectedBook.is_reserved &&
        this.selectedBook.current_reservation.user_id !== this.selectedUser.id
      ) {
        if (!send) {
          this.setState("confirm");
          return;
        }
        alertify
          .confirm(
            "Kniha je rezervována",
            `Knihu má zaregistrovanou uživatel ${this.selectedBook.current_reservation.user.name}, chcete rezervaci zrušit
                a knihu vypůjčit?`,
            () => {
              this.selectedBook
                .clearReservation()
                .then(this.borrowBook.bind(this))
                .then(this.clearBook.bind(this));
            },
            () => {
              alertify.message("Kniha nebyla vypůjčena");
            }
          )
          .set("labels", {
            ok: "Zrušit rezervaci a půjčit",
            cancel: "Nepůjčovat",
          });
      } else {
        if (!send) {
          this.setState("confirm");
          return;
        }
        this.borrowBook();
      }
    },
    borrowBook() {
      this.selectedBook.borrow(this.selectedUser).then((response) => {
        if (response.data.success) {
          this.selectedUser.activeBorrows = response.data.borrow.user?.activeBorrows;
          this.clearBook();
        }
      });
    },

    inputBook(send = true) {
      let code = this.bookInput.value;
      axios(`/book/code/${code}`)
        .then((response) => {
          this.selectedBook = book(response.data);
          this.bookInput.value = "";
          this.updateState(send);
        })
        .catch((error) => {
          if (error.status === 404) {
            alertify.error("Kniha nebyla nalezena");
          } else {
            alertify.error("Při hledání knihy se vyskytl problém");
          }
        });
    },
    inputUser(send = true) {
      let identification = this.userInput.value;
      axios(`/user/search/${identification}`)
        .then((response) => {
          this.selectedUser = user(response.data);
          this.userInput.value = "";
          if (
            this.selectedUser.role.string === "registered" &&
            !this.selectedUser.school_class
          ) {
            this.promptRegisteredUser(send);
          } else {
            this.updateState(send);
          }
        })
        .catch((error) => {
          alertify.error(
            error.status === 404
              ? "Uživatel nebyl nalezen"
              : "Při hledání uživatele se vyskytl problém"
          );
        });
    },
    promptRegisteredUser(send) {
      alertify.skippablePrompt({
        title: "Nový uživatel",
        message:
          "Uživatel je poprvé v knihovně a nemá zadanou třídu. Třídu můžete upravit níže:",
        label: "Třída",
        onOk: (input) => {
          this.selectedUser
            .update({
              school_class: input,
            })
            .then(() => {
              aleritfy.success(
                `Úprava uživatele ${this.selectedUser.name} byla úspěšná`
              );
            })
            .catch(() => {
              alertify.error(
                `Při úpravě uživatele ${this.selectedUser.name} se vyskytla chyba`
              );
            });
          this.updateState(send);
        },
        onSkip: () => {
          this.updateState(send);
        },
        onCancel: () => {},
      });
    },
  },
};
</script>
