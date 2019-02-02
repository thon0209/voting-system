<template>
  <div class="container">
    <h3>Manage Official Candidates</h3>
    <div class="row">
      <div class="col-lg-3 col-md-3">
        <div class="card">
          <div class="card-header bg-primary text-white">Add Official Candidate</div>
          <div class="container py-3">
            <div
              class="alert alert-danger"
              v-for="error in errors.full_name"
              :key="error.key"
            >{{ error }}</div>
            <div
              class="alert alert-danger"
              v-for="error in errors.course"
              :key="error.key"
            >{{ error }}</div>
            <div
              class="alert alert-danger"
              v-for="error in errors.position_id"
              :key="error.key"
            >{{ error }}</div>
            <div
              class="alert alert-danger"
              v-for="error in errors.party_id"
              :key="error.key"
            >{{ error }}</div>
            <form @submit.prevent="addCandidate()">
              <div class="form-group">
                <label for="name">Candidate Full Name</label>
                <input
                  type="text"
                  v-model="candidate.full_name"
                  class="form-control"
                  id="name"
                  placeholder="Enter full name"
                >
                <label for="course">Candidate Course</label>
                <input
                  type="text"
                  v-model="candidate.course"
                  class="form-control"
                  id="course"
                  placeholder="Enter course"
                >
                <label for="position">Position</label>
                <select class="form-control" id="position" v-model="candidate.position_id">
                  <option
                    v-for="position in positions"
                    v-bind:value="position.id"
                    :key="position.id"
                  >{{position.position}}</option>
                </select>
                <label for="party">Party List</label>
                <select class="form-control" id="party" v-model="candidate.party_id">
                  <option
                    v-for="party in parties"
                    v-bind:value="party.id"
                    :key="party.id"
                  >{{party.party_name}}</option>
                </select>
                <label for="election">Election</label>
                <select class="form-control" id="election" v-model="candidate.election_id">
                  <option
                    v-for="election in elections"
                    v-bind:value="election.id"
                    :key="election.id"
                  >{{election.election_title}}</option>
                </select>
              </div>

              <button type="submit" class="btn btn-success float-right">Save</button>
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
                <th scope="col">#</th>
                <th scope="col">Candidate</th>
                <th scope="col">Position</th>
                <th scope="col">Party List</th>
                <th scope="col">Election</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(candidate,index) in candidates" :key="candidate.index">
                <th scope="row">{{index+1}}</th>
                <td>{{candidate.full_name}} {{candidate.course}}</td>
                <td>{{candidate.position.position}}</td>
                <td>{{candidate.party.party_name}}</td>
                <td>{{candidate.election.election_title}}</td>
                <td>
                  <button
                    type="button"
                    @click="editCandidate(candidate)"
                    class="btn btn-primary"
                  >Edit</button>
                  <button
                    type="button"
                    @click="deleteCandidate(candidate)"
                    class="btn btn-danger"
                  >Delete</button>
                </td>
              </tr>
              <tr v-if="candidates.length<1">
                <td>No candidate.</td>
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
      candidates: [],
      positions: [],
      elections: [],
      parties: [],
      errors: [],
      isEdit: false,
      cardTitle: "Add Party List",
      candidate: {
        full_name: "",
        course: "",
        position_id: "",
        party_id: "",
        election_id: ""
      },
      image: ""
    };
  },
  mounted() {
    this.loadCandidate();
    this.loadPosition();
    this.loadPartyList();
    this.loadElection();
  },
  methods: {
    loadCandidate() {
      axios.get("../api/candidates").then(response => {
        this.candidates = response.data.data;
      });
    },
    loadElection() {
      axios.get("../api/get-election").then(response => {
        this.elections = response.data.elections;
      });
    },
    loadPosition() {
      axios.get("../api/get-position").then(response => {
        this.positions = response.data.positions;
      });
    },
    loadPartyList() {
      axios.get("../api/get-party").then(response => {
        this.parties = response.data.parties;
      });
    },
    addCandidate() {
      if (this.isEdit === false) {
        axios
          .post("../api/candidates", this.candidate)
          .then(response => {
            method: "post";
            this.candidates.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "New candidate has added successfully",
              timeout: 3000
            }).show();
            this.candidate = {
              full_name: "",
              course: "",
              position_id: "",
              party_id: "",
              election_id: ""
            };
            this.loadCandidate();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      } else {
        axios
          .patch("../api/candidates/" + this.candidate.id, this.candidate)
          .then(response => {
            method: "put";
            this.candidates.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "Candidate has edit successfully",
              timeout: 3000
            }).show();
            this.candidate = {
              full_name: "",
              course: "",
              position_id: "",
              party_id: "",
              election_id: ""
            };
            this.isEdit = false;
            this.loadCandidate();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      }
    },
    editCandidate(edit) {
      this.isEdit = true;
      this.candidate = edit;
      this.cardTitle = "Edit candidate List";
    },
    cancel() {
      this.cardTitle = "Add candidate List";
      this.isEdit = false;
      this.errors = "";
      this.candidate = {
        full_name: "",
        course: "",
        position_id: "",
        party_id: "",
        election_id: ""
      };
    },
    deleteCandidate(candidate) {
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
            .delete("../api/candidates/" + candidate.id)
            .then(response => {
              let index = this.candidates.indexOf(candidate);
              this.candidates.splice(index, 1);
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


