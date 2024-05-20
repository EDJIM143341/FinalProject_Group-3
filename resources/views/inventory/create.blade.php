@extends('layouts.app')
@section('content')
    <main class="container">
        <a href="{{ route('inventory.index') }}" class="btn btn-primary" style=" margin-top: 1em;
        border: 1px solid #e0e0e0;
        background-color: white;
        color: var(--text-dark);
        padding: 9px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-family: var(--font-family);
        text-decoration: none;">Back</a>

        <section>
            <form method="post" action="{{route('inventory.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="titlebar">
                    <h1>Add Inventory</h1>
                   
                </div>
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error )
                                <li> {{$error}} </li>
                            @endforeach
                        </ul>
                    </div>       
                @endif

                <div class="card">
                <div>
                    <label for="weapon_id">Weapon</label>
                    <select name="weapon_id" id="weapon_id" class="form-control">
                        @foreach($weapons as $weapon)
                        <option value="{{ $weapon->id }}">{{ $weapon->weapon_name }} - {{ $weapon->weapon_type }}</option>
                        @endforeach
                    </select>

                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" required>

                    <label for="condition">Condition</label>
                    <input type="text" name="condition" id="condition" class="form-control" required>

                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" required>
                       
                    </div>
                </div>
                <div class="titlebar">
                    <h1></h1>
                    <button>Save</button>
                </div>
            </form>
        </section>
    </main>
    <script>
        function showFile(event){
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('file-preview');
                output.src = dataURL;
            }
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection