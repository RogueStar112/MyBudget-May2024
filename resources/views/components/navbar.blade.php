<nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
            
            <a class="navbar-brand ms-2 skew10deg fw-bolder" style="background-color: {{$brandColor}};" href="#">{{ $brandName }}</a>
            
            <button id="navbar-reveal" class="navbar-toggler visible md:collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            </div>

            <div class="w-3/4 mx-auto" id="navbarsExample03">
              <ul class="navbar-nav flex-col md:flex-row flex-start w-full me-auto mb-2 mb-sm-0">
                {{$items}}
              </ul>
            </div>
</nav>

<script>

document.getElementById('navbar-reveal').addEventListener('click', () => {
  document.getElementById('navbarsExample03').classList.toggle('collapse');
});

</script>

