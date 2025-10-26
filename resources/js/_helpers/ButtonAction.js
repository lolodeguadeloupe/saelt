import $ from 'jquery';

export const bouttonAction = function ($propiete) {
    var params = $.extend(true, {}, {
        class: 'fa-edit',
        title: 'action',
        action: null,
        session: null,
        callback: null
    }, $propiete = $propiete || {}), element = $(this);
    var btnClass = params.class.split(' ');
    btnClass = btnClass.length > 1 ? btnClass[1] : 'btn-info';
    return $('<div/>',
        {
            'class': 'box-tools btn-remove',
            'style': 'margin-top:0px;margin-bottom:0px;display: inline-block;margin-right:5px'
        }
    ).append(
        $('<button/>',
            {
                'type': 'button',
                'class': 'btn btn-sm ' + btnClass,
                'style': 'font-size: 8px;',
                'title': params.title
            }
        ).addTitle().append(
            $('<i/>',
                {
                    'class': 'fa ' + params.class
                }
            ).clone(true)
        ).click(
            function () {
                if (typeof params.callback === 'function')
                    params.callback.apply($(this), [$(this), params.action, params.session])
            }).clone(true)
    )

    /*
      
     <div class="pull-right box-tools btn-remove" style="margin-top:0px;margin-bottom:0px;">
     <button type="button" class="btn btn-info btn-sm" style="font-size: 8px;" title="modifier"><i class="fa fa-edit"></i></button></div>
     
     */
}