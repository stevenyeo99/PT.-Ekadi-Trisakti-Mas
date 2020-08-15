<!-- <footer id="footerContact" style="position: absolute; bottom: 0; padding: 0 20px; padding-bottom: 20px; background: #5cb85c; width: 100%;"> -->
<footer id="footerContact" style="width: 100%; height: 1px; bottom: 0; display: table-row;">
    <div id="content" style="padding: 20px; height: auto; background-color: #5cb85c;">
      <!--Section heading-->
      <h2 class="h1-responsive font-weight-bold text-center my-4">Contact us</h2>
      <!--Section description-->
      <p id="textPromote" class="text-center w-responsive mx-auto mb-5">
        Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
          a matter of hours to help you.
      </p>

      <div class="row">
          <!--Grid column-->
          <div class="col-md-9 mb-md-0 mb-5">
              <form autocomplete="off">
                  <!--Grid row-->
                  <div class="row">
                      <!--Grid column-->
                      <div class="col-md-6">
                          <div class="md-form mb-0">
                              <input type="text" id="txtName" name="name" class="form-control">
                              <label for="name" class="">Your name</label>
                          </div>
                      </div>
                      <!--Grid column-->

                      <!--Grid column-->
                      <div class="col-md-6">
                          <div class="md-form mb-0">
                              <input type="email" id="txtEmail" name="email" class="form-control">
                              <label for="email" class="">Your email</label>
                          </div>
                      </div>
                      <!--Grid column-->
                  </div>
                  <!--Grid row-->

                  <!--Grid row-->
                  <div class="row">
                      <div class="col-md-12">
                          <div class="md-form mb-0">
                              <input type="text" id="txtSubject" name="subject" class="form-control">
                              <label for="subject" class="">Subject</label>
                          </div>
                      </div>
                  </div>
                  <!--Grid row-->

                  <!--Grid row-->
                  <div class="row">
                      <!--Grid column-->
                      <div class="col-md-12">
                          <div class="md-form">
                              <textarea type="text" id="txtMessage" name="message" rows="2" class="form-control md-textarea"  ></textarea>
                              <label for="message">Your message</label>
                          </div>
                      </div>
                  </div>
                  <!--Grid row-->
              <div class="text-center text-md-left">
                  <button type="button" class="btn btn-primary" id="btnSendMail">Send</button>
                  <button type="button" class="btn btn-danger" id="btnReset">Reset</button>
              </div>
            </form>
              <!-- <div class="status"></div> -->
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-3 text-center">
              <ul class="list-unstyled mb-0">
                  <a id="googleMap" target="_blank" href="https://www.google.com/maps/place/PT.+Ekadi+Trisakti+Mas/@1.1278229,104.0043056,15z/data=!4m12!1m6!3m5!1s0x31d98bf3177bbfed:0xf71602d579becc34!2sPT.+Ekadi+Trisakti+Mas!8m2!3d1.1278361!4d104.0041758!3m4!1s0x31d98bf3177bbfed:0xf71602d579becc34!8m2!3d1.1278361!4d104.0041758">
                    <li class="contactIcon">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                        <p>
                          42H3+4M Utama, Baloi Indah, Batam City, Riau Islands
                        </p>
                    </li>
                  </a>

                  <a id="waContact"  href="" target="_blank">
                    <li class="contactIcon">
                        <i class="fas fa-phone mt-4 fa-2x"></i>
                        <p>WA: +62 813 7264 7955</p>
                    </li>
                  </a>

                  <a id="emailContact">
                    <li class="contactIcon">
                        <i class="fas fa-envelope mt-4 fa-2x"></i>
                        <p>
                          stevenyeo70@gmail.com
                          <br>
                          hendi@uib.ac.id
                        </p>
                    </li>
                  </a>
              </ul>
          </div>
          <!--Grid column-->
      </div>
    </div>
  </footer>
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/css/mdb.min.css" rel="stylesheet">
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>

  <script type="text/javascript" src="{{ asset('public/js/footerContactForm.js') }}"></script>

  <style>
      div.md-form input[type=text]:focus:not([readonly]),
      div.md-form input[type=email]:focus:not([readonly]),
      div.md-form textarea.md-textarea:focus:not([readonly]) {
        -webkit-box-shadow: 0 1px 0 0 #cbdc57;
        box-shadow: 0 1px 0 0 #cbdc57;
        border-bottom: 1px solid #cbdc57;
        color: #cbdc57;
      }
      div.md-form input[type=text]:focus:not([readonly])+label,
      div.md-form input[type=email]:focus:not([readonly])+label,
      div.md-form textarea.md-textarea:focus:not([readonly])+label
      {
        color: #cbdc57;
      }

      div.md-form textarea.md-textarea~label.active {
        color: #FFFFFF;
      }

      footer h2,
      footer p,
      footer i,
      .md-form label {
          color: #ffffff;
      }

      footer i:hover {
        color: #cbdc57;
      }
  </style>
</body>
</html>
