<template>
  <section class="search">
    <div class="search-bar">
      <div class="input-group input-group-lg mb-3">
        <input
          type="text"
          class="form-control"
          placeholder="Search in our library..."
        />
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
      <div class="search-results">
        <div class="total">Showing 9170 results (1 second)</div>
        <div class="item">
          <div class="title">Required Reading for Microsoft AZ-104 Exam</div>
          <div class="list-txt">
            <div class="txt">Author: Sovath</div>
            <div class="txt">Page number: 100</div>
          </div>
          <div class="des">
            Before taking Microsoft’s AZ-104 exam, please read the pages at the
            following links because these specific topics were not covered
            anywhere else in this learning path: Administrative units in Azure
            Active Directory Bulk create users in Azure Active Directory Create
            a management group Assign share-level permissions to an identity
            Object replication for block blobs Use the Azure
          </div>
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
export default {
  
}
</script>