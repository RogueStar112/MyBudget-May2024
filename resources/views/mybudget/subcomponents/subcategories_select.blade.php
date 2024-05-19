@isset($subcategories)
@foreach($subcategories as $subcategory)

    <option value={{$subcategory->id}} id="subcategory-choice-{{subcategory->id}}" name="{{$subcategory->name}}">{{$subcategory->name}}</option>

@endforeach
@endisset