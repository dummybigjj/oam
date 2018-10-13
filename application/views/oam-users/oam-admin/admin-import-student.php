          <section>
            <div class="container-fluid">
              <div class="card">
                <div class="card-header">
                  <div class="statistic d-flex align-items-center no-padding-top no-padding-bottom">
                    <div class="icon bg-red"><i class="fa fa-upload" aria-hidden="true"></i></div>
                    <div class="text"><small class="h5">Import New Students</small></div>
                  </div>
                </div>
                <div class="card-body">  
                  <p>Allowed formats are (.xlxs) and (.xls) only.</p>
                  <div class="row">
                    <div class="col-xl-8">
                      <!-- <form action="student/import_students" method="post" enctype="multipart/form-data" class="dropzone">
                        <div class="fallback">
                          <input type="file" name="file_upload" />
                        </div>
                        <div class="dz-message">
                          <p>Drop files here or click to upload.</p>
                        </div>
                        <input type="submit" name="import_student" class="form-control">
                      </form> -->

                      <form action="student/import_students" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" />
                        <input type="submit" name="import_student" class="form-control">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>