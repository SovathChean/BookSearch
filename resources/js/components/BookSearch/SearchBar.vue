<template>
  <section class="search">
    <div class="search-bar">
      <form @submit.prevent="query">
        <div class="input-group input-group-lg mb-3">
          <div class="input-group-prepend">
            <select v-model="type" class="form-select select-box" aria-label="Default select example">
              <option value="1" selected>Title</option>
              <option value="2">Description</option>
              <option value="3">Author</option>
            </select>
          </div>
          <input
            type="text"
            class="form-control search-box"
            name="query"
            v-model="runtimeTranscription_"
            placeholder="Search in our library..."
            required
          />

          <div class="input-group-append">
            <button class="btn btn-search" type="submit">
              <i class="fas fa-search"></i>
            </button>
            <div
              class="audio speech-to-txt row justify-content-md-center"
              @click="startSpeechToTxt"
            >
              <i class="fas fa-microphone fa-lg p-3"></i>

              <transition name="slide-fade">
                <div v-if="loader_" class="row justify-content-md-center pl-3">
                  <h2>Listening</h2>
                  <BounceLoader
                    :size="'45px'"
                    :color="'#0055D4'"
                    :loading="loader_"
                  />
                </div>
              </transition>
            </div>
            
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
        <div v-show="total != 0" class="total">
          Showing {{ books.total }} results ({{ books.time_spend }} seconds)
        </div>
        <div v-for="book in books.data" :key="book.id" class="item">
          <div class="title">{{ book.title }}</div>
          <div class="list-txt">
            <div class="txt">Author: {{book.authors}}</div>
            <div class="txt">Page number: {{book.pageCount}}</div>
          </div>
          <div class="des">
            {{ book.description}}
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
import Loading from "vue-loading-overlay";
import BounceLoader from "@bit/greyby.vue-spinner.bounce-loader";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  data() {
    return {
      runtimeTranscription_: "",
      lang_: "en-EN",
      loader_: false,
      type: 1,
      length: 0,
      total: 0,
      books: [],
      fields: {},
      isLoading: false,
      fullPage: true,
    };
  },
  components: {
    Loading,
    BounceLoader,
  },
  methods: {
    async query() {
      this.isLoading = true;
      this.fields.query = this.runtimeTranscription_;
      this.fields.type = this.type
      const res = await axios.post("api/search", this.fields);
      this.books = res?.data;
      this.total = this.books.total;
      if (res) {
        this.isLoading = false;
      }
    },

    startSpeechToTxt() {
      // initialisation of voicereco
      this.loader_ = true;
      window.SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;
      const recognition = new window.SpeechRecognition();
      recognition.lang = this.lang_;
      recognition.interimResults = true;

      // event current voice reco word
      recognition.addEventListener("result", (event) => {
        var text = Array.from(event.results)
          .map((result) => result[0])
          .map((result) => result.transcript)
          .join("");
        this.runtimeTranscription_ = text;
        this.fields.query = this.runtimeTranscription_;
      });
      // end of transcription
      recognition.addEventListener("end", () => {
        recognition.stop();
        this.loader_ = false;
      });
      recognition.start();
    },
  },
};
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
