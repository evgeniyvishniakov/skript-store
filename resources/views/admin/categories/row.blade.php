<tr id="category-row-{{ $category->id }}" data-id="{{ $category->id }}" class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="category-name font-medium text-gray-900">
            {{ $category->name }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
    <span class="category-type px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
        {{ $category->type->label ?? $category->type->name ?? 'Не указан' }}
    </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $category->products_count ?? 0 }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            <button class="edit-category"
                    data-id="{{ $category->id }}"
                    data-name="{{ $category->name }}"
                    data-type-id="{{ $category->type_id }}"
                    data-type-label="{{ $category->type->label }}"
                    title="Редактировать">
                <i class="fas fa-edit"></i>
            </button>
            <form class="delete-form inline" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" title="Удалить">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
