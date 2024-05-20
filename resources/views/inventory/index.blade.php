@extends('layouts.app')
@section('content')
<main class="container">
    <a href="{{ route('weapons.index') }}" class="btn btn-primary" style=" margin-top: 1em;
    border: 1px solid #e0e0e0;
    background-color: white;
    color: var(--text-dark);
    padding: 9px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-family: var(--font-family);
    text-decoration: none;">Back</a>
    <section>
        <div class="titlebar">
            <h1>Weapon Inventory List</h1>
            <a href="{{route('inventory.create')}}" class='btn-link'>Add Inventory</a>

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

            <form method="GET" action="{{route('inventory.index')}}" accept-charset="UTF-8" role="search">   
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
                <p>Inventory ID</p>
                <p>Weapon Name</p>
                <p>Weapon Type</p>
                <p>quantity</p>
                <p>Condition</p>
                <p>Price</p>
                <p>Actions</p>
            </div>

            <div class="table-product-body">
                @if (count($inventories) > 0)
                    @foreach ($inventories as $inventory )
                        <p> {{$inventory->inventory_id}}</p>
                        <p> {{$inventory->weapon->weapon_name}}</p>
                        <p>{{$inventory->weapon->weapon_type}}</p>
                        <p>{{$inventory->quantity}}</p>
                        <p>{{$inventory->condition}}</p>
                        <p>{{$inventory->price}}</p>
                        
                        <div style="display: flex">     
                            {{-- <a href="{{route('weapons.edit', $inventory->inventory_id)}}" class="btn-link btn btn-success" style="padding-top:4px; padding-bottom:4px">
                                <i class="fas fa-pencil-alt" ></i> 
                            </a> --}}

                            <form method="post" action="{{ route('inventory.destroy', $inventory->inventory_id) }}">
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
                {{$inventories->links('layouts.pagination')}}
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
