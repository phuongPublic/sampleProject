<!-- Modal -->
<div class="modal company-modal" tabindex="-1" role="dialog" style="">
    <input type="hidden" name="show_modal" id="show_modal" value="{{ old( 'show_modal', isset($data->show_modal) ? $data->show_modal : 0) }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <a href="javascript:void(0)" class="close company-close">
                    <span aria-hidden="true">&times;</span>
                </a>

            </div>
            <div class="modal-body text-center">
                <div class="text-left  col-sm-10 offset-sm-1">
                    <p>{{__('企業情報に登録した住所に認証コードを郵送でお送りします。30日以内にマイページからコードを入力し認証してください。')}}</p>
                    <p>{{__('30日を経過してコードの認証が確認できない場合、企業アカウントは停止となり、掲載中の記事は停止されます。')}}</p>
                    <p>{{__('企業情報の変更は、この先の画面ではできません。')}}</p>
                </div>
                <a href="javascript:void(0)" class="btn btn-primary mgt-40 bold company-close" >{{__('もういちど企業情報を確認する')}}</a>
                <a href="javascript:void(0)" id="company_submit" class="btn btn-primary mgt-40 bold" >{{__('企業情報を登録し、認証コードを発行。記事掲載に進む')}}</a>
            </div>
        </div>
    </div>
</div>
