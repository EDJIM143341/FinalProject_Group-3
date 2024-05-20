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
            <form method="post" action="{{route('weapons.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="titlebar">
                    <h1>Add Weapon</h1>
                   
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
                        <label>Weapon Name</label>
                        <input type="text" name="weapon_name" >
                        
                        <label>Manufacturer</label>
                        <input type="text" name="manufacturer" >

                        <label>Weapon Type</label>
                        <select  name="weapon_type" >
                            @foreach(json_decode('{"Hand Gun":"Hand Gun","Riffle":"Riffle","Submachine Gun":"Submachine Gun","Melee Weapon":"Melee Weapon","Sniper Riffle":"Sniper Riffle"}', true) as $optionKey => $optionValue)
                                <option value="{{$optionKey}}">{{$optionValue}}</option>
                            @endforeach 
                        
                        </select>
                       
                    </div>

                <div>
                     
                        <label>Add Image</label>
                        <img src="" alt="" class="img-product" id="file-preview" />
                        <input type="file" name="image" accept="image/*" onchange=showFile(event)  >
                        {{-- <hr>
                        <label>Inventory</label>
                        <input type="text" name="quantity" >
                        <hr>
                        <label>Price</label>
                        <input type="text" name="price" > --}}
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