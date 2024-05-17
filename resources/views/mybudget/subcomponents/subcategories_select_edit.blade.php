@isset($subcategories)
@foreach($subcategories as $subcategory)
    @if($loop->first)
    <option selected>Select a subcategory</option>
    @endif
    <option value={{$subcategory->id}} onClick="editSubcategoryFields_editform({{$subcategory->id}})" name="{{$subcategory->name}}">{{$subcategory->name}}</option>

@endforeach
@endisset