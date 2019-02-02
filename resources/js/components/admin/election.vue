<template>
  <div class="container">
    <h3>Manage Official Election</h3>
    <div class="row">
      <div class="col-lg-3 col-md-3">
        <div class="card">
          <div class="card-header bg-primary text-white">Add Election</div>
          <div class="container py-3">
            <div
              class="alert alert-danger"
              v-for="error in errors.election_title"
              :key="error.key"
            >{{ error }}</div>
            <div
              class="alert alert-danger"
              v-for="error in errors.start"
              :key="error.key"
            >{{ error }}</div>
            <div class="alert alert-danger" v-for="error in errors.end" :key="error.key">{{ error }}</div>
            <form @submit.prevent="addElection()">
              <div class="form-group">
                <label for="position">Election</label>
                <input
                  type="text"
                  v-model="election.election_title"
                  class="form-control"
                  id="position"
                  placeholder="Enter election"
                >
              </div>
              <div class="form-group">
                <label for="position">Start Date</label>
                <input type="date" v-model="election.start" class="form-control" id="position">
              </div>
              <div class="form-group">
                <label for="position">End Date</label>
                <input type="date" v-model="election.end" class="form-control" id="position">
              </div>
              <div class="form-group">
                <label for="isActived">Active</label>
                <select v-model="election.isActived" class="form-control">
                  <option
                    v-for="isActivedOption in isActivedOptions"
                    v-bind:value="isActivedOption.value"
                  >{{isActivedOption.text}}</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary float-right">Save</button>
            </form>
            <button @click="cancel()" class="btn btn-info text-white">Cancel</button>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9">
        <div class="card">
          <div class="card-header bg-primary text-white">List of Election</div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Election</th>
                <th scope="col">Start</th>
                <th scope="col">End</th>
                <th scope="col">Active</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(election,index) in elections" :key="election.index">
                <th scope="row">{{index+1}}</th>
                <td>{{election.election_title}}</td>
                <td>{{election.start}}</td>
                <td>{{election.end}}</td>
                <td v-if="election.isActived == 0">Yes</td>
                <td v-else>No</td>
                <td>
                  <button type="button" @click="editElection(election)" class="btn btn-primary">Edit</button>
                  <button
                    type="button"
                    @click="deleteElection(election)"
                    class="btn btn-danger"
                  >Delete</button>
                </td>
              </tr>
              <tr v-if="elections.length<1">
                <td>No election.</td>
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
      elections: [],
      errors: [],
      isEdit: false,
      cardTitle: "Add Election",
      election: {
        election_title: "",
        start: "",
        end: "",
        isActived: ""
      },
      isActivedOptions: [
        { text: "No", value: "1" },
        { text: "Yes", value: "0" }
      ]
    };
  },
  mounted() {
    this.loadElection();
  },
  methods: {
    loadElection() {
      axios.get("../api/elections").then(response => {
        this.elections = response.data.data;
      });
    },
    addElection() {
      if (this.isEdit === false) {
        axios
          .post("../api/elections", this.election)
          .then(response => {
            method: "post";
            this.elections.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "New election has added successfully",
              timeout: 3000
            }).show();
            this.election = {
              election_title: "",
              start: "",
              end: "",
              isActived: ""
            };
            this.loadElection();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      } else {
        axios
          .patch("../api/elections/" + this.election.id, this.election)
          .then(response => {
            method: "put";
            this.elections.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "Party list has edit successfully",
              timeout: 3000
            }).show();
            this.election = {
              election_title: "",
              start: "",
              end: "",
              isActived: ""
            };
            this.isEdit = false;
            this.loadElection();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      }
    },
    editElection(edit) {
      this.isEdit = true;
      this.election = edit;
      this.cardTitle = "Edit election List";
    },
    cancel() {
      this.cardTitle = "Add election List";
      this.isEdit = false;
      this.errors = "";
      this.election = {
        election_title: "",
        start: "",
        end: "",
        isActived: ""
      };
    },
    deleteElection(election) {
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
            .delete("../api/elections/" + election.id)
            .then(response => {
              let index = this.elections.indexOf(election);
              this.elections.splice(index, 1);
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
