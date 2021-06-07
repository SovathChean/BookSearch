<template>
  <section class="search">
    <div class="search-bar">
      <form @submit.prevent="query">
       
        <div class="input-group input-group-lg mb-3">
          <input
            type="text"
            class="form-control"
            name="query"
            v-model="fields.query"
            placeholder="Search in our library..."
          />
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
              
      </form>
       <loading
        :active.sync="isLoading"
        :can-cancel="true"
        :is-full-page="fullPage"
      >
      </loading>
        <div class="search-results">
          <div class="total">
            Showing {{ books.total }} results ({{ books.time_spend }} seconds)
          </div>
          <div v-for="book in books.data" :key="book.id" class="item">
            <div class="title">{{ book.title }}</div>
            <div class="list-txt">
              <div class="txt">Author: Sovath</div>
              <div class="txt">Page number: 100</div>
            </div>
            <div class="des">
              Before taking Microsoft’s AZ-104 exam, please read the pages at
              the following links because these specific topics were not covered
              anywhere else in this learning path: Administrative units in Azure
              Active Directory Bulk create users in Azure Active Directory
              Create a management group Assign share-level permissions to an
              identity Object replication for block blobs Use the Azure
            </div>
          </div>
          <div v-if="total == 0" class="empty">
            <div class="icon"><i class="far fa-frown fa-4x"></i></div>
            <div class="txt">No resutls found</div>
          </div>
        </div>

      <!-- <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </nav> -->
    </div>
  </section>
</template>

<script>
import axios from "axios";
import Loading from 'vue-loading-overlay';
    // Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
  data() {
    return {
      length: 0,
      total: 0,
      books: [],
      fields: {}, 
      isLoading: false,
      fullPage: true
    };
  },
  components: {
      Loading
  },
  methods: {
    async query() {
      this.isLoading = true;
      
      const res = await axios.post("api/search", this.fields);
      this.books = res?.data;
      this.total = this.books.total;
      if(res){
         this.isLoading = false
      }

    }
  }
};
</script>
