import { makeReservation } from "./makeReservation"

export function makeBook(bookObject) {
  return {
    ...bookObject,
    deleted: false,
    reservations: bookObject.reservations?.map(reservationObject => makeReservation(reservationObject)),
    destroy() {
      return axios.delete(`/book/${this.id}`)
        .then(response => {
          alertify.success("Kniha byla smazána.")
          this.deleted = true
          return response
        }).catch(error => {
          alertify.error("Knihu se nepodařilo smazat")
          throw error
        })
    },
    reserve() {
      return axios.post(`reservation`, {book: this.id})
        .then((response) => {
          if (response.data.success) {
            alertify.success(`Kniha ${this.title} byla rezervována`);
            Object.assign(this, response.data.book);
            return true;
          } else {
            alertify.error(`Knihu ${this.title} se nepodařilo rezervovat: ${response.data.message}`);
          }
          return response
        }).catch((error) => {
          if(error.response.status === 401)
          alertify.error(`Knihu ${this.title} se nepodařilo rezervovat: Nejste přihlášen`);
          else
          alertify.error(`Knihu ${this.title} se nepodařilo rezervovat: ${error.response.data.message}`);
          throw error
        });
    },
    borrow(user) {
      return axios.post(`/book/${this.id}/borrow/${user.id}`)
        .then((response) => {
          if (response.data.success === true) {
            alertify.success("Kniha byla vypůjčena.");

          } else {
            alertify.error(
              "Knihu se nepodařilo vypůjčit: " + response.data.message
            );
          }
          return response
        }).catch(error => {
          alertify.error(
            "Nepodařilo se odeslat požadavek na vypůjčení knihy."
          );
          throw error
        });
    },
    return() {
      return axios
        .post(`/book/${this.id}/return`)
        .then((response) => {
          if (response.data.success === true) {
            alertify.success("Kniha byla vrácena.");
          } else {
            alertify.error("Knihu se nepodařilo vrátit: " + response.data.message);
          }
          return response
        }).catch(error => {
          alertify.error("Nepodařilo se odeslat požadavek na vrácení knihy.");
          throw error
        });
    },
    clearReservation() {
      return this.current_reservation.destroy().then((response) => {
        this.is_reserved = false
        return response
      })
    },

  }
}
