    <!-- @Page Loader -->
    <!-- =================================================== -->
    <div id='loader'>
        <div class="spinner"></div>
      </div>
      <script type="text/javascript">
        window.addEventListener('load', () => {
          const loader = document.getElementById('loader');
          setTimeout(() => {
            loader.classList.add('fadeOut');
          }, 300);
          if('editor-choice' == '{{$segment}}'){
            $('#top-pick-holder').css('display', 'block');
          }
        });
      </script>