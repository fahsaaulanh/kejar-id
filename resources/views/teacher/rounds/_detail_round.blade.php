{{-- Modal Deskripsi Ronde --}}
<div class="modal fade" id="detailDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="detailDescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content kotak justify-content-center">
          <div class="content">
              <div class="modal-header border-0">
                  <div class="judul">
                      <!-- Breadcrumbs -->
                      <nav class="breadcrumb bg-transparent p-0">
                          <span class="breadcrumb-item active">{{ 'Babak ' . $stage['order'] }}</span>
                          <span class="breadcrumb-item active">{{ 'Ronde ' . $round['order'] }}</span>
                      </nav>
                      <!-- Title -->
                      <h1 class="text-title">{{ $round['title'] }}</h1>
                  </div>
                  <button type="button" class="close" data-dismiss="modal">
                      <span aria-hidden="true"><i class="kejar-close"></i></span>
                  </button>
              </div>
              <div class="modal-body border-0">
                  <!-- Detail -->
                  <div class="task-detail">
                      <p class="title-group">Deskripsi Ronde</p>
                      <h5 class="task-detail-amount"> <span>{{ $round['total_question'] }}</span> soal ditampilkan</h5>
                      <p class="task-detail-description">{{ $round['description'] }}</p>
                      <br>
                      <p class="title-group">Materi Untuk Siswa</p>
                      <div class="detail-card rounded-0 border-0">
                          <div class="detail-card-icon">
                              <i class="kejar-open-book"></i>
                          </div>
                          <div class="detail-card-text">
                              {{ $round['direction'] }}
                          </div>
                      </div>
                  </div>
                  <!-- Button Tutup -->
                  <div class="d-flex justify-content-end btn-start-group" >
                      <button class="btn btn-primary btn-start d-flex align-items-center" data-dismiss="modal">
                          Tutup
                      </button>
                  </div> 
              </div>
          </div> 
      </div>
  </div>
</div>
