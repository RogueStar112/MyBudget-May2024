<nav class="navbar navbar-dark bg-dark font-MontserratRegular p-4" aria-label="Third navbar example">
            <div class="">
            
            <a class="navbar-brand ms-2 skew10deg fw-bolder" style="background-color: {{$brandColor}};" href="#">{{ $brandName }}</a>
            
            <button id="navbar-reveal" class="navbar-toggler md:hidden" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            </div>

            <div class="hidden md:block" id="navbarsExample03">
              <ul class="navbar-nav flex-col md:flex-row flex-start w-full me-auto mb-2 mb-sm-0">
                {{$items}}
              </ul>
            </div>
</nav>

<script type="text/javascript" defer>


  document.getElementById('navbar-reveal').addEventListener('click', () => {
    document.getElementById('navbarsExample03').classList.toggle('hidden');
  });

</script>

