<x-navbar :brandName="$brandName" brandColor="green" >
            <x-slot name="items">
                {{-- <x-navbar-item url="/.." title="HOME" color="#198754" icon="home" /> --}}
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg flex items-center">APPS</p>
                <x-navbar-item url="/budgeting-app" title="BUDGET" color="green" icon="money-bill-alt" selected/>
                {{-- <x-navbar-item url="/nutrition-app" title="HEALTH" color="orange" icon="dumbbell" />
                <x-navbar-item url="/journalling-app" title="WRITE" color="red" icon="pencil-alt" />
                <x-navbar-item url="/reviewing-app" title="REVIEW" color="blue" icon="star" /> --}}
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg flex items-center">USER</p>
                <x-navbar-item url="/login" title="LOGIN" color="lightblue" icon="user-alt"/>
                <x-navbar-item url="/register" title="REGISTER" color="skyblue" icon="user-plus"/>
                <x-navbar-item url="/settings" title="SETTINGS" color="grey" icon="cog"/>
                {{-- <x-navbar-item url="/logout" title="LOGOUT" color="red" icon="sign-out-alt" /> --}}
                <li nav-item m-1 relative justify-around items-center flex text-center" style="width: 64px; height: 80px; border-radius: 9999px;">
                    <a class="nav-link h-full w-full rounded-full" style="background-color: red; height: 64px; href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt flex justify-center items-center h-full"></i>
                        <div class="label-bottom">LOGOUT</div>    
                    </a>
                </li>
                {{-- <form method="POST" action="{{route('logout')}}" style="background-color: red;">
                    @csrf
                    <input class="nav-link" type="submit" />
                    <i class="fas fa-logout" />
                    <div class="label-bottom">LOGOUT</div>
                </form> --}}


                <div class="diagonal-divider"></div>
                
                <p class="m-3" style="text-align: right; color: white; font-family: Montserrat;">Welcome, {{Auth::user()->name}}.</p>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
            </x-slot>

         
</x-navbar>