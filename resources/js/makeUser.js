import axios from "axios"
import { makeReservation } from "./makeReservation"

export function makeUser(userObject) {
  let user = {
    ...userObject,
    errors: null,
    deleted: false,
    activeBorrows: userObject.borrows?.filter((borrow) => borrow.is_active).length,
    reservations: userObject.reservations?.map(reservationObj => {return makeReservation(reservationObj)}),
    update(data) {
      return axios.put(`/user/${this.id}`, data)
        .then(response => {
          Object.assign(this, response.data)
          return response
        }).catch((error) => {
          this.errors = Object.values(error.response.data?.errors)
          alertify.error("Uživatel nebyl upraven")
          return error
        })
    },
    destroy() {
      return axios.delete(`/user/${this.id}`)
        .then(response => {
          this.deleted = true
          alertify.success("Uživatel byl smazán.")
          return response
        }).catch(error => {
          alertify.error("Uživatele se nepodařilo smazat")
          return error
        });
    }
  }
  return user
}
