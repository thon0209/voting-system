<template>
  <div class="container">
    <h3>Voters Log</h3>
    <div class="row">
      <div class="col-4">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">Show</span>
          </div>
          <input
            @keyup.enter="fetchIndexData()"
            v-model="per_page"
            type="text"
            class="text-center"
            style="width:20%;"
          >
          <div class="input-group-prepend">
            <span class="input-group-text">entries</span>
          </div>
        </div>
      </div>
      <div class="col-4">
        <button type="submit" @click="pdfReport()" class="btn btn-primary">Print Report</button>
      </div>
    </div>
    <table class="table table-sm table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Student ID</th>
          <th scope="col">Candidate</th>
          <th scope="col">Date Time Vote</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="log in logs" :key="log.id">
          <td>{{log.user.username}}</td>
          <td>{{log.candidate.full_name}}</td>
          <td>{{log.timestamp_vote}}</td>
        </tr>
      </tbody>
    </table>
    <div class="float-left">
      <label>Showing {{ meta.current_page }} to {{ meta.last_page }} of {{ meta.total }} entries</label>
    </div>

    <div class="float-right">
      <ul class="pagination">
        <li>
          <button
            type="button"
            class="btn btn-default"
            @click="firstPage"
            :disabled="!this.links.first"
          >&laquo;</button>
        </li>
        <li>
          <button
            type="button"
            class="btn btn-default"
            @click="prevPage"
            :disabled="!this.links.prev"
          >Previous</button>
        </li>
        <li>
          <button
            type="button"
            class="btn btn-default"
            @click="nextPage"
            :disabled="!this.links.next"
          >Next</button>
        </li>
        <li>
          <button
            type="button"
            class="btn btn-default"
            @click="lastPage"
            :disabled="!this.links.last"
          >&raquo;</button>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      links: [],
      meta: [],
      page: 1,
      per_page: 15,
      logs: []
    };
  },
  mounted() {
    this.loadVotingLog();
  },
  methods: {
    pdfReport() {
      window.open("././vote-logs/print", "_blank");
    },
    loadVotingLog() {
      axios.get("././api/polling-log").then(response => {
        this.logs = response.data.data;
        this.links = response.data.links;
        this.meta = response.data.meta;
      });
    },
    fetchIndexData() {
      axios
        .get(
          "././api/polling-log" +
            "?page=" +
            this.page +
            "&per_page=" +
            this.per_page
        )
        .then(response => {
          this.logs = response.data.data;
          this.links = response.data.links;
          this.meta = response.data.meta;
        });
    }, //end fetchCustomer
    prevPage() {
      axios
        .get(
          this.links.prev +
            "&per_page=" +
            this.per_page +
            "&search=" +
            this.search
        )
        .then(response => {
          this.logs = response.data.data;
          this.links = response.data.links;
          this.meta = response.data.meta;
        });
    }, //end of  prevPage()
    nextPage() {
      axios
        .get(
          this.links.next +
            "&per_page=" +
            this.per_page +
            "&search=" +
            this.search
        )
        .then(response => {
          this.logs = response.data.data;
          this.links = response.data.links;
          this.meta = response.data.meta;
        });
    }, //end of nextPage()
    firstPage() {
      axios
        .get(
          this.links.first +
            "&per_page=" +
            this.per_page +
            "&search=" +
            this.search
        )
        .then(response => {
          this.logs = response.data.data;
          this.links = response.data.links;
          this.meta = response.data.meta;
        });
    }, //end firstPage()
    lastPage() {
      axios
        .get(
          this.links.last +
            "&per_page=" +
            this.per_page +
            "&search=" +
            this.search
        )
        .then(response => {
          this.logs = response.data.data;
          this.links = response.data.links;
          this.meta = response.data.meta;
        });
    } //end lastPage()
  }
};
</script>

