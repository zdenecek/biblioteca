export function makeReservation(reservationObject) {
  return {
    ...reservationObject,
    deleted: false,
    destroy() {
      return axios.delete(`/reservation/${this.id}`)
        .then((response) => {
          this.deleted = true
          alertify.success("Rezervace byla smazána.");
          return response
        }).catch((error) => {
          alertify.error("Rezervaci se nepodařilo smazat");
          throw error
        });
    },
  }
}
