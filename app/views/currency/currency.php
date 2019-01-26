<link rel="stylesheet" href="/static/assets/currency/currency.css">

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="convert shadow p-4 mb-4 bg-white">

                <h3 class="badge-light" align="center">Конвертация валют</h3>

                <form id="convertForm" action="#" class="form-group">

                    <label>
                        <input type="number" name="amount" step="0.01" min="0" value="" placeholder="Введите значение" class="form-control form-control-sm">
                    </label>

                    <label>
                        <select name="convertFrom" class="form-control form-control-sm">

                            <?php foreach($settingsTypes as $type):?>

                                <option value="<?php echo $type;?>" <?php echo $type == 'usd' ? 'selected' : '';?>><?php echo strtoupper($type);?></option>

                            <?php endforeach;?>

                        </select>
                    </label>

                    <span>в</span>

                    <label>
                        <select name="convertTo" class="form-control form-control-sm">

                            <?php foreach($settingsTypes as $type):?>

                                <option value="<?php echo $type;?>" <?php echo $type == 'uah' ? 'selected' : '';?>><?php echo strtoupper($type);?></option>

                            <?php endforeach;?>

                        </select>
                    </label>

                    <input type="submit" class="btn btn-outline-success btn-sm" value="Конвертировать">

                </form>

                <div class="col-sm-12 convertResponse alert alert-info">

                    <div class="row">

                        <div class="col-sm-4">

                            <label for="basic-url">Результат</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">
                                         <img class="loading" src="/static/graphics/loading.gif" alt="Загрузка..." width="25" height="25">
                                    </span>
                                </div>

                                <input type="number" class="responseValue form-control" id="basic-url" value="" aria-describedby="basic-addon3" readonly required>
                            </div>

                        </div>

                        <div class="col-sm-auto responseMessage alert alert-warning"></div>

                    </div>

                </div>

            </div>

            <div class="history shadow p-4 mb-4 bg-white">

                <h3 class="badge-light" align="center">История конвертаций</h3>

                <?php if($history):?>

                <table class="table table-hover text-center">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Описание</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php $num = 1;?>

                        <?php foreach($history as $h):?>

                            <tr>
                                <td><?php echo $num;?></td>
                                <td><?php echo $h->getAmount();?> <?php echo $h->getConvertFrom();?> - <?php echo $h->getResult();?> <?php echo $h->getConvertTo();?></td>
                                <td><?php echo $h->getCreateDate(true);?></td>
                            </tr>

                        <?php $num++;?>

                        <?php endforeach;?>

                    </tbody>
                </table>

                <?php else:?>

                    <div class="alert alert-warning" align="center">
                        <p>Данных о истории пока нет...</p>
                    </div>

                <?php endif;?>

            </div>

        </div>

        <div class="col-md-12">

            <button type="button" class="settingsToggle btn btn-outline-secondary btn-block" data-toggle="modal" data-target="#settingsModal">
                Настройки
            </button>

        </div>

    </div><!-- end row -->

    <!-- Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title">Настройки</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form id="settingsForm" action="#" class="form-group">

                        <div class="col-sm-auto">

                            <label>
                                Максимальное выводимое кол-во записей истории:
                                <input type="number" class="form-control" name="maxRecords" step="1" min="0" max="100" value="<?php echo $maxRecords;?>">
                            </label>
                            <input type="submit" class="btn btn-outline-success btn-sm" value="Сохранить">

                        </div>

                        <div class="custom-control custom-checkbox">

                            <ul class="list-group">
                                Отображаемые валюты:
                                <?php foreach($allTypes as $type):?>

                                    <?php
                                    $currencySymbol = array_key_exists('currencySymbol',$type) ? $type['currencySymbol'] : "";
                                    $checked = in_array(strtolower($type['id']),$settingsTypes);
                                    ?>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?php echo $checked ? 'list-group-item-info' : ''?>">

                                        <span>
                                            <?php echo $type['id'] ." - " .$type['currencyName'] . " (" . $currencySymbol . ")";?>
                                        </span>

                                        <label>
                                            <input style="transform: scale(1.5);" type="checkbox" name="currencyType[<?php echo strtolower($type['id']);?>]" <?php echo $checked ? 'checked' : '';?>>
                                        </label>

                                    </li>

                                <?php endforeach;?>
                            </ul>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Закрыть</button>
<!--                    <span class="btn btn-outline-info btn-sm scrollUp">Вверх</span>-->
                    <input type="submit" form="settingsForm" class="btn btn-outline-success btn-sm" value="Сохранить">

                </div>
            </div>
        </div>
    </div> <!-- end Modal -->

</div><!-- end container -->

<script type="text/javascript" src="/static/assets/currency/currency.js"></script>