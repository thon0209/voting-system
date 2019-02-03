<template>
  <div class="container">
    <vue-progress-bar></vue-progress-bar>
    <h3>Manage Voters</h3>
    <div class="row">
      <div class="col-lg-3 col-md-3">
        <div class="card">
          <div class="card-header bg-primary text-white">Add Voter</div>
          <div class="container py-3">
            <!-- <div
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
            >{{ error }}</div>-->
            <form @submit.prevent="addUser()">
              <div class="form-group">
                <label for="name">Full Name</label>
                <input
                  type="text"
                  v-model="user.name"
                  class="form-control"
                  id="name"
                  placeholder="Enter full name"
                >
                <label for="course">Course</label>
                <input
                  type="text"
                  v-model="user.course"
                  class="form-control"
                  id="course"
                  placeholder="Enter course"
                >
                <label for="username">Username</label>
                <input
                  type="text"
                  v-model="user.username"
                  class="form-control"
                  id="username"
                  placeholder="Enter user name"
                >
                <label for="email">Email</label>
                <input
                  type="email"
                  v-model="user.email"
                  class="form-control"
                  id="email"
                  placeholder="Enter email"
                >
                <label for="password">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  v-model="user.password"
                  placeholder="Enter password"
                >
              </div>

              <button type="submit" class="btn btn-success float-right">Save</button>
            </form>

            <button @click="cancel()" class="btn btn-info text-white">Cancel</button>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9">
        <div class="card">
          <div class="card-header bg-primary text-white">List of Voter</div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Username</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user,index) in users" :key="user.index">
                <th scope="row">{{index+1}}</th>
                <td>{{user.name}}</td>
                <td>{{user.course}}</td>
                <td>{{user.username}}</td>
                <td>
                  <button type="button" @click="editUser(user)" class="btn btn-primary">Edit</button>
                  <button type="button" @click="deleteUser(user)" class="btn btn-danger">Delete</button>
                </td>
              </tr>
              <tr v-if="users.length<1">
                <td>No user.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row py-3">
      <div class="col-lg-3 col-md-3">
        <div class="card">
          <div class="card-header bg-primary text-white">Upload File (.xlsx)</div>
          <div class="container py-3">
            <div v-if="!file">
              <input type="file" id="file" name="file" ref="file" v-on:change="fileUpload">
            </div>
            <div v-else>
              <input type="submit" value="Upload" @click="submitFile">
            </div>
          </div>
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
      users: [],
      isEdit: false,
      cardTitle: "Add Voter",
      user: {
        name: "",
        course: "",
        username: "",
        email: "",
        password: "",
        isAdmin: 0,
        isVoted: 0
      },
      file: ""
    };
  },
  mounted() {
    this.loadUser();
  },
  methods: {
    fileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append("file", this.file);
      axios
        .post("./api/user-upload", formData, {
          headers: { "Content-Type": "multipart/form-data" },
          onUploadProgress: function() {
            this.$Progress.start();
          }.bind(this)
        })
        .then(function() {
          // this.$Progress.finish();
          swal(
            "Good job!",
            "File has been uploaded. Please refresh the page.",
            "success"
          );
        })
        .catch(function() {
          console.log("failed to upload");
        });
    },
    loadUser() {
      axios.get("../api/users").then(response => {
        this.users = response.data.data;
      });
    },
    addUser() {
      if (this.isEdit === false) {
        axios
          .post("../api/users", this.user)
          .then(response => {
            method: "post";
            this.users.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "New candidate has added successfully",
              timeout: 3000
            }).show();
            this.user = {
              name: "",
              course: "",
              username: "",
              email: "",
              password: "",
              isAdmin: 0,
              isVoted: 0
            };
            this.loadUser();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      } else {
        axios
          .patch("../api/users/" + this.user.id, this.user)
          .then(response => {
            method: "put";
            this.users.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "Candidate has edit successfully",
              timeout: 3000
            }).show();
            this.user = {
              name: "",
              course: "",
              username: "",
              email: "",
              password: "",
              isAdmin: 0,
              isVoted: 0
            };
            this.isEdit = false;
            this.loadUser();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      }
    },
    editUser(edit) {
      this.isEdit = true;
      this.user = edit;
      this.cardTitle = "Edit voter List";
    },
    cancel() {
      this.cardTitle = "Add voter List";
      this.isEdit = false;
      this.errors = "";
      this.user = {
        name: "",
        course: "",
        username: "",
        email: "",
        password: "",
        isAdmin: 0,
        isVoted: 0
      };
    },
    deleteUser(user) {
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
            .delete("../api/users/" + user.id)
            .then(response => {
              let index = this.users.indexOf(user);
              this.users.splice(index, 1);
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


