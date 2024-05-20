@extends('layouts.app')
@section('content')
<main class="container">
    <section>
        <div class="titlebar">
            <h1>Weapon List</h1>
            <a href="{{route('weapons.create')}}" class='btn-link'>Add Weapon</a>
            <a href="{{ route('weapon.inventory.index') }}" class='btn-link'>Add Inventory</a>

        </div>
        @if ($message = Session::get('success'))
        <script type="text/javascript">
            const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
            Toast.fire({
            icon: "success",
            title: '{{$message}}'
            });
        </script>           
    @endif

        <div class="table">
            <div class="table-filter">
                <div>
                    <ul class="table-filter-list">
                        <li>
                            <p class="table-filter-link link-active">All</p>
                        </li>
                    </ul>
                </div>
            </div>

            <form method="GET" action="{{route('weapons.index')}}" accept-charset="UTF-8" role="search">   
                <div class="table-search">   
                    <div>
                        <button class="search-select">
                        Search
                        </button>
                        <span class="search-select-arrow">
                            <i class="fas fa-caret-down"></i>
                        </span>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Search weapon..." name="search" value="{{ request('search') }}">
                    </div>
                </div>
            </form>

            <div class="table-product-head">
                <p>Image</p>
                <p>Weapon Name</p>
                <p>Weapon Type</p>
                <p>Manufacturer</p>
                <p>Actions</p>
            </div>

            <div class="table-product-body">
                @if (count($weapons) > 0)
                    @foreach ($weapons as $weapon )
                        <img src="{{ asset('images/' . $weapon->image)}}"/>
                        <p> {{$weapon->weapon_name}}</p>
                        <p>{{$weapon->weapon_type}}</p>
                        <p>{{$weapon->manufacturer}}</p>
                        
                        <div style="display: flex">     
                            <a href="{{route('weapons.edit', $weapon->id)}}" class="btn-link btn btn-success" style="padding-top:4px; padding-bottom:4px ">
                                <i class="fas fa-pencil-alt" ></i> 
                            </a>

                            <form method ="post" action="{{route('weapons.destroy', $weapon->id)}}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="deleteConfirm(event)">
                                    <i class="far fa-trash-alt"></i>
                                </button>

                            </form>
                            
                        </div>
                    @endforeach
                @else
                        <p style="color: red;">Weapon not Found</p>
                @endif
                
            </div>
            <div class="table-paginate">
                {{$weapons->links('layouts.pagination')}}
            </div>
        </div>
    </section>
   
</main>
<script>
    window.deleteConfirm = function (e){
        e.preventDefault();
        var form = e.target.form;
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed){
                form.submit();
            }

        })
    }
        
</script>
@endsection