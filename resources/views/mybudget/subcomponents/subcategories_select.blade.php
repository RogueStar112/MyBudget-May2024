@isset($subcategories)
@foreach($subcategories as $subcategory)

    <option value={{$subcategory->id}} name="{{$subcategory->name}}">{{$subcategory->name}}</option>

@endforeach
@endisset