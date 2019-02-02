<template>
  <div class="container">
    <h3>Vote Information</h3>
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="card">
          <div class="container py-3">
            <form @submit.prevent="addVote" type="POST">
              <ul class="list-group">
                <li class="list-group-item" v-for="position in positions" :key="position.id">
                  <b>{{ position.position }} :</b>
                  <div v-for="(cadidate_selected,index) in selected" :key="index">
                    <div v-if="cadidate_selected.position_id === position.id">
                      {{cadidate_selected.full_name}}
                      <br>
                      <i>{{cadidate_selected.party.party_name}}</i>
                      <button
                        type="submit"
                        class="btn btn-danger btn-sm float-right"
                        @click="remove(index)"
                      >X</button>
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
                          @click="vote(candidate)"
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
  computed: {},
  methods: {
    vote(candidate) {
      this.selected.push(candidate);
    },
    remove(index) {
      this.selected.splice(index, 1);
    },
    addVote() {
      axios
        .post("../api/voting", this.selected)
        .then(response => {
          method: "post";
          this.selected.push(response.data.data);
        })
        .catch(response => {
          this.errors = response.response.data.errors;
        });
    },
    loadPosition() {
      axios.get("../api/positions").then(response => {
        this.positions = response.data.data;
      });
    },
    loadCandidate() {
      axios.get("../api/candidates").then(response => {
        this.candidates = response.data.data;
      });
    },
    loadParty() {
      axios.get("../api/parties").then(response => {
        this.parties = response.data.data;
      });
    }
  }
};
</script>
