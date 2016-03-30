                                    <table class="table table-striped table-bordered table-hover order-column" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th> id</th>
                                                <th>拼音缩写 </th>
                                                <th> 名称</th>
                                                <th> 拼音 </th>
                                                <th> 三字码</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($rows as $r){
                                            echo'
                                            <tr class="odd gradeX">
                                                <td> '.$r['id'].' </td>
                                                <td>
                                                   '.$r['shortalphabetic'].' 
                                                </td>
                                                <td>'.$r['name'].'</td>
                                                <td class="center">'.$r['alphabetic'].'</td>
                                                <td>
                                                   '.$r['code'].' 
                                                </td>
                                                </tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
