<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<table border="1">
    <tbody>
        <tr style="border:1px solid">
            <td>{!! trans('hegyd-faqs::newsletters.field.first_name') !!}</td>
            <td>{!! trans('hegyd-faqs::newsletters.field.last_name') !!}</td>
            <td>{!! trans('hegyd-faqs::newsletters.field.email') !!}</td>
            <td>{!! trans('hegyd-faqs::newsletters.field.active') !!}</td>
            <td>{!! trans('hegyd-faqs::newsletters.field.updated_at') !!}</td>
        </tr>
        @foreach($newsletters as $newsletter)
            <tr class="gradeX">
                <td>{!! $newsletter->first_name ? $newsletter->first_name : '' !!}</td>
                <td>{!! $newsletter->last_name ? $newsletter->last_name : '' !!}</td>
                <td>{!! $newsletter->email ? $newsletter->email : '' !!}</td>
                <td>{!! $newsletter->active ? $newsletter->active : '' !!}</td>
                <td>{{$newsletter->updated_at->format('d/m/Y à H:i')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
