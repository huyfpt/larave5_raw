<div class="white-box">

    <h3 class="box-title">@lang("dashboard.connexions.title.connexions")</h3>
    <div class="comment-center vCat">
        @if( count($connexions) > 0 )
            <table class="table">
                <tr>
                    <th>Utilisateur</th>
                    <th>Date</th>
                    <th>Rôle</th>
                </tr>
                @foreach($connexions as $c)
                    @if($c->user)
                        <tr>
                            <td>{!! $c->user->fullname() !!}</td>
                            <td>{!! $c->created_at->format('d-m-Y H:i:s') !!}</td>
                            <td>{!! $c->user->roles()->first()->display_name !!}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @else
            <div class="comment-body">
                <p class="text-center">@lang("dashboard.connexions.labels.no_recent_connexion")</p>
            </div>
        @endif
    </div>
</div>