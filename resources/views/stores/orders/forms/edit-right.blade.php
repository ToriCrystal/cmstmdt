<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"/>
                <x-button type="submit" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </x-button>
            </div>
        </div>
    </div>
    <!-- driver -->
    <div class="card mb-3">
        <div class="card-header">
            @lang('driver')
        </div>
        <div class="card-body p-2">
            <x-select disabled name="driver_id" class="select2-bs5-ajax-many"
                      :data-url="route('admin.search.select.driver')"
                      :required="true">
                <x-select-option :option="$order->driver_id" :value="$order->driver_id"
                                 :title="$order->driver->user->fullname . ' - ' . $order->driver->user->phone"/>
            </x-select>
        </div>
    </div>
    <!-- status -->
    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select disabled name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$order->status->value" :value="$key" :title="__($value)" />
                @endforeach
            </x-select>
        </div>
    </div>

</div>
