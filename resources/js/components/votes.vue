<template>
  <div class="container">
    <h3>Vote Information</h3>
    <h6 class="text-danger">
      Instructions: To vote, click
      <input type="radio" disabled> round button to the left of your choices, like this:
      <input type="radio" checked>. VOTE WISELY!
    </h6>
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="card">
          <div class="container py-3">
            <form @submit.prevent="addVote">
              <ul class="list-group">
                <li class="list-group-item" v-for="position in positions" :key="position.id">
                  <b>{{ position.position }} :</b>
                  <div v-for="(cadidate_selected,index) in selected" :key="index">
                    <div v-if="cadidate_selected.position_id === position.id">
                      {{cadidate_selected.full_name}}
                      <br>
                      <i>{{cadidate_selected.party.party_name}}</i>
                    </div>
                  </div>
                </li>
                <button type="submit" class="btn btn-primary">Submit Vote</button>
              </ul>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8 col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white">Select Candidates</div>
          <!-- -->
          <div class="container py-2">
            <div class="panel panel-info" v-for="position in positions" :key="position.id">
              <div class="panel-heading">
                <strong>{{ position.position }}</strong>
              </div>
              <div class="panel-body table-responsive">
                <table class="table table-hover table-borderless table-sm">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th></th>
                      <th>Name</th>
                      <th width="40%">Party List</th>
                      <th hidden></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="candidate in candidates"
                      v-if="candidate.position_id==position.id"
                      :key="candidate.id"
                    >
                      <td>
                        <input
                          type="radio"
                          :name="position.id"
                          :id="candidate.id"
                          :value="candidate.id"
                          @change="vote(candidate,position)"
                        >
                      </td>
                      <td>{{candidate.full_name}} ({{candidate.course}})</td>
                      <td>{{candidate.party.party_name}}</td>
                      <td hidden>{{candidate.election.election_title}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- -->
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
      candidates: [],
      parties: [],
      selected: [],
      errors: ""
    };
  },
  mounted() {
    this.loadPosition();
    this.loadCandidate();
    this.loadParty();
  },
  methods: {
    vote(candidate, position) {
      var found = false;
      for (var i = 0; i < this.selected.length; i++) {
        if (this.selected[i].position_id === position.id) {
          var newVote = this.selected[i];
          found = true;
          break;
        }
      }
      if (!found) {
        this.selected.push(candidate);
      }
    },
    remove(index) {
      this.selected.splice(index, 1);
    },
    addVote() {
      swal({
        title: "Are you sure?",
        text: "Once voted, you will not be able to modify your vote!",
        icon: "info",
        buttons: true,
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          axios
            .post("././api/voting", this.selected)
            .then(response => {
              method: "post";
              const file = JSON.parse(data);
              this.selected.json();
            })
            .catch(response => {
              this.errors = response.response.data.errors;
            });
          swal("SUCCESS! Your voted has been counted. Thank you!", {
            icon: "success"
          });
          location.replace("././vote-done");
        } else {
          swal(
            "Please press F5 key or press refresh button to reset your vote."
          );
        }
      });
    },
    loadPosition() {
      axios.get("././api/positions").then(response => {
        this.positions = response.data.data;
      });
    },
    loadCandidate() {
      axios.get("././api/candidates").then(response => {
        this.candidates = response.data.data;
      });
    },
    loadParty() {
      axios.get("././api/parties").then(response => {
        this.parties = response.data.data;
      });
    }
  }
};
</script>
