@php
    $menu['Dashboard'] = [

                'url'=> route('system.dashboard'),
                'icon'=>'<i class="fa fas fa-th"></i>',
                'text'=>__('Dashboard'),
         ];

        $menu['Measurements'] = [

                'url'=> route('system.measurements'),
                'icon'=>'<i class="fas fa-ruler"></i>',
                'text'=>__('Measurements'),
         ];


        $menu['Company'] = [

                'url'=> route('system.company.index'),
                'icon'=>'<i class="fas fa-building"></i>',
                'text'=>__('Company'),
         ];

        $menu['Warehouse'] = [
                'url'=> route('system.warehouse.index'),
                'icon'=>'<i class="fas fa-warehouse"></i>',
                'text'=>__('Warehouse'),
         ];

        $menu['Inventory'] = [

                'url'=> route('system.inventory.index'),
                'icon'=>'<i class="fas fa-store-alt"></i>',
                'text'=>__('Inventory'),
         ];

        $menu['ActivityLog'] = [
                'permission'=> ['system.activity-log.index'],
                'url'=> route('system.activity-log.index'),
                'icon'=>'<i class="fa fa-cog"></i>',
                'text'=> __('Audit trail'),
         ];


        $menu['users']= [
              'permission'=>[ 'system.staff.index' , 'system.staff.show','system.staff.create'],
               'icon'=>'<i class="fa fa-users"></i>',
               'url'=> route('system.staff.index'),
               'text'=> __('Users')
        ];

@endphp

@foreach($menu as $onemenu)
    {!! generateMenu($onemenu) !!}
@endforeach
