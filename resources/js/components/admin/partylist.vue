<template>
  <div class="container">
    <h3>Manage Official Party List</h3>
    <div class="row">
      <div class="col-lg-3 col-md-3">
        <div class="card">
          <div class="card-header bg-primary text-white">Add Party List</div>
          <div class="container py-3">
            <div
              class="alert alert-danger"
              v-for="error in errors.party"
              :key="error.key"
            >{{ error }}</div>
            <form @submit.prevent="addParty()">
              <div class="form-group">
                <label for="party">Party List</label>
                <input
                  type="text"
                  v-model="party.party_name"
                  class="form-control"
                  id="party"
                  placeholder="Enter party list"
                >
              </div>
              <button type="submit" class="btn btn-primary float-right">Save</button>
            </form>
            <button @click="cancel()" class="btn btn-info text-white">Cancel</button>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9">
        <div class="card">
          <div class="card-header bg-primary text-white">List of Position</div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th scope="col">Party List</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(party, index) in parties" :key="party.id">
                <td>{{index+1}}</td>
                <td>{{party.party_name}}</td>
                <td>
                  <button type="button" @click="editParty(party)" class="btn btn-primary">Edit</button>
                  <button type="button" @click="deleteParty(party)" class="btn btn-danger">Delete</button>
                </td>
              </tr>
              <tr v-if="parties.length<1">
                <td>No party list.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import swal from "sweetalert";
export default {
  data() {
    return {
      parties: [],
      errors: [],
      isEdit: false,
      cardTitle: "Add Party List",
      party: {
        party_name: ""
      }
    };
  },
  mounted() {
    this.loadParty();
  },
  methods: {
    loadParty() {
      axios.get("./api/parties").then(response => {
        this.parties = response.data.data;
      });
    },
    addParty() {
      if (this.isEdit === false) {
        axios
          .post("./api/parties", this.party)
          .then(response => {
            method: "post";
            this.parties.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "New party list has added successfully",
              timeout: 3000
            }).show();
            this.party = {
              party: ""
            };
            this.loadParty();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      } else {
        axios
          .patch("./api/parties/" + this.party.id, this.party)
          .then(response => {
            method: "put";
            this.parties.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "Party list has edit successfully",
              timeout: 3000
            }).show();
            this.party = {
              party_name: ""
            };
            this.isEdit = false;
            this.loadParty();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      }
    },
    editParty(edit) {
      this.isEdit = true;
      this.party = edit;
      this.cardTitle = "Edit Party List";
    },
    cancel() {
      this.cardTitle = "Add Party List";
      this.isEdit = false;
      this.errors = "";
      this.party = {
        party_name: ""
      };
    },
    deleteParty(party) {
      swal({
        title: "Are you sure?",
        text:
          "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          axios
            .delete("./api/parties/" + party.id)
            .then(response => {
              let index = this.parties.indexOf(party);
              this.parties.splice(index, 1);
            })
            .catch(response => {
              this.abort = response.response.data.errors;
            });
          swal("Poof! Your imaginary file has been deleted!", {
            icon: "success"
          });
        } else {
          swal("Your imaginary file is safe!");
        }
      });
    }
  }
};
</script>
