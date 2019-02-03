<template>
  <div class="container">
    <h3>Manage Official Positions</h3>
    <div class="row">
      <div class="col-lg-3 col-md-3">
        <div class="card">
          <div class="card-header bg-primary text-white">{{cardTitle}}</div>
          <div class="container py-3">
            <div
              class="alert alert-danger"
              v-for="error in errors.position"
              :key="error.key"
            >{{ error }}</div>
            <form @submit.prevent="addPosition()">
              <div class="form-group">
                <label for="position">Position</label>
                <input
                  type="text"
                  v-model="position.position"
                  class="form-control"
                  id="position"
                  placeholder="Enter position"
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
          <div class="card-header bg-primary text-white">List of Position</div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Position</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(position,index) in positions" :key="position.index">
                <th scope="row">{{index+1}}</th>
                <td>{{position.position}}</td>
                <td>
                  <button type="button" @click="editPosition(position)" class="btn btn-primary">Edit</button>
                  <button
                    type="button"
                    @click="deletePosition(position)"
                    class="btn btn-danger"
                  >Delete</button>
                </td>
              </tr>
              <tr v-if="positions.length<1">
                <td>No position.</td>
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
      positions: [],
      errors: [],
      isEdit: false,
      cardTitle: "Add Official Position",
      position: {
        position: ""
      }
    };
  },
  mounted() {
    this.loadPosition();
  },
  methods: {
    loadPosition() {
      axios.get("../api/positions").then(response => {
        this.positions = response.data.data;
      });
    },
    addPosition() {
      if (this.isEdit === false) {
        axios
          .post("../api/positions", this.position)
          .then(response => {
            method: "post";
            this.positions.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "New position has added successfully",
              timeout: 3000
            }).show();
            this.position = {
              position: ""
            };
            this.loadPosition();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      } else {
        axios
          .patch("../api/positions/" + this.position.id, this.position)
          .then(response => {
            method: "put";
            this.positions.push(response.data.data);
            new Noty({
              type: "success",
              layout: "bottomRight",
              text: "Position has edit successfully",
              timeout: 3000
            }).show();
            this.position = {
              position: ""
            };
            this.isEdit = false;
            this.loadPosition();
            this.errors = "";
          })
          .catch(response => {
            this.errors = response.response.data.errors;
          });
      }
    },
    editPosition(edit) {
      this.isEdit = true;
      this.position = edit;
      this.cardTitle = "Edit Official Position";
    },
    cancel() {
      this.cardTitle = "Add Official Position";
      this.isEdit = false;
      this.errors = "";
      this.position = {
        position: ""
      };
    },
    deletePosition(position) {
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
            .delete("../api/positions/" + position.id)
            .then(response => {
              let index = this.positions.indexOf(position);
              this.positions.splice(index, 1);
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
