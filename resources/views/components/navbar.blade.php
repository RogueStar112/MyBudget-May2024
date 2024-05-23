<nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
            
            <a class="navbar-brand ms-2 skew10deg fw-bolder" style="background-color: {{$brandColor}};" href="#">{{ $brandName }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="" id="navbarsExample03">
                  <ul class="navbar-nav flex-start w-full me-auto mb-2 mb-sm-0">
                    {{$items}}
                  </ul>
            </div>
            </div>
</nav>

