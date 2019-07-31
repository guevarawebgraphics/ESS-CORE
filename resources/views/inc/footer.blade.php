<footer id="footer">
      <!-- Show Announcement -->
  <div class="modal fade" id="Announcement_to_notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h1 id="announcement_title" class="text-center"></h1>
                <p id="announcement_description" class="text-center"></p>
            </div>
          </div>
        </div>
      </div>
    
    {{-- <!-- To the right -->
    <div class="float-right d-none d-sm-block-down">
        Anything you want
    </div><!-- Default to the left --> --}}
    <div class="text-center">
        <div class="text-lg-center text-white">Copyright &copy; {{ now()->year }} CSI . All rights reserved</div>
    </div>
</footer>