<input type="checkbox" class="make-switch" {!! $checked ? 'checked' : '' !!}
       data-on="success" data-on-color="success" data-on-text="@Lang('app.yes')"
       data-off-color="warning" data-size="small" data-off-text="@Lang('app.no')"
       data-switch-url='{{ route($config['prefixes']['route'] . $field['switchRoute'], ['id' => $id])  }}'
>
