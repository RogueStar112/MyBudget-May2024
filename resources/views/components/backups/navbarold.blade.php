<nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
            
            <a class="navbar-brand ms-2 bg-success skew10deg fw-bolder" href="#">{{ $brandName }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample03">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">

                <div class="diagonal-divider"></div>

                <!-- budgeting -->
                <li class="nav-item bg-orange-skew-np m-1">
                    <a class="nav-link" aria-current="page" href="/.."><i class="fas fa-home"></i><p> | Budgeting</p><div class="label-bottom">HOME</div></a>
                </li>

                <!-- fitness/dieting -->
                <li class="nav-item bg-warning m-1">
                    <a class="nav-link" href="/fitness-app"><i class="fas fa-dumbbell"></i><p> | Fitness</p><div class="label-bottom">FITNESS</div></a>
                </li>

                <!-- journalling -->
                <li class="nav-item bg-danger m-1">
                    <a class="nav-link" href="/journalling-app" tabindex="-1" aria-disabled="true"><i class="fas fa-pencil-alt"></i><p> | Journalling</p><div class="label-bottom">JOURNAL</div></a>
                </li>

                <!-- reviews -->
                <li class="nav-item bg-info m-1">
                    <a class="nav-link" href="/reviewing-app" tabindex="-1" aria-disabled="true"><i class="fas fa-star"></i><p> | Reviewing</p><div class="label-bottom">REVIEWS</div></a>
                </li>
                
                <div class="diagonal-divider"></div>

                <!-- login -->
                <li class="nav-item bg-primary m-1 item-square flex-row-reverse">
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-user-alt"></i><p> | Settings</p><div class="label-bottom">LOGIN</div></a>
                </li>

                <!-- settings -->
                <li class="nav-item bg-secondary m-1 item-square flex-row-reverse">
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-cog"></i><p> | Settings</p><div class="label-bottom">SETTINGS</div></a>
                </li>

   
                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown03">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                -->

                </ul>

                <!--
                <form>
                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                </form>
                 -->
            </div>
            </div>
</nav>