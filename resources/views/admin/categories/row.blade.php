<tr id="category-row-{{ $category->id }}" data-id="{{ $category->id }}" class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="category-name font-medium text-gray-900">
            {{ $category->name }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="category-type px-2 inline-flex text-xs leading-5 font-semibold rounded-full
            {{ $category->type == 'framework' ? 'bg-blue-100 text-blue-800' : '' }}
            {{ $category->type == 'language' ? 'bg-green-100 text-green-800' : '' }}
            {{ $category->type == 'topic' ? 'bg-purple-100 text-purple-800' : '' }}
            {{ $category->type == 'tool' ? 'bg-yellow-100 text-yellow-800' : '' }}">
            {{ $category->type }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $category->products_count ?? 0 }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            <button class="edit-category text-indigo-600 hover:text-indigo-900"
                    data-id="{{ $category->id }}"
                    data-name="{{ $category->name }}"
                    data-type="{{ $category->type }}"
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
