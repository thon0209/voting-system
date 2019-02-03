<template>
  <div class="container">
    <h4>Candidate Polling Results</h4>
    <div class="card">
      <ul class="list-group">
        <div class="list-group-item" v-for="position in positions" :key="position.id">
          <strong>{{position.position}}</strong>
          <table class="table table-borderless table-sm">
            <thead class="bg-primary text-white">
              <tr>
                <th width="50%">Name</th>
                <th width="40%">Party List</th>
                <th width="40%">Vote Count(s)</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="candidate in candidates"
                v-if="candidate.position_id==position.id"
                :key="candidate.id"
              >
                <td>{{candidate.full_name}}</td>
                <td
                  v-for="party in parties"
                  v-if="party.id==candidate.party_id"
                  :key="party.id"
                >{{candidate.party.party_name}}</td>
                <td
                  v-for="poll in polling"
                  v-if="poll.candidate_id==candidate.id"
                  :key="poll.id"
                >{{poll.totalVote}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </ul>
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
      polling: []
    };
  },
  mounted() {
    this.loadPosition();
    this.loadCandidate();
    this.loadParty();
    this.loadPolling();
  },
  methods: {
    loadPolling() {
      axios.get("././api/polling").then(response => {
        this.polling = response.data.data;
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

