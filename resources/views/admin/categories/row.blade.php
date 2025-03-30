
<tr id="category-row-{{ $category->id }}" data-id="{{ $category->id }}">
    <td>{{ $category->id }}</td>
    <td>
        <!-- Элемент с классом .badge -->
        <span class="badge" style="background: {{ $category->color }}">
            {{ $category->name }}
        </span>
    </td>
    <td>
        <!-- Элемент с классом .category-type -->
        <span class="category-type">{{ $category->type }}</span>
    </td>
    <td class="btn_cat">
        <!-- Кнопки действий -->
        <button class="btn btn-sm btn-warning edit-category"
                data-id="{{ $category->id }}"
                data-name="{{ $category->name }}"
                data-type="{{ $category->type }}"
                data-color="{{ $category->color }}">
            <i class="fa fa-edit"></i>
        </button>
        <form class="delete-form" action="{{ route('categories.destroy', $category->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    </td>
</tr>
