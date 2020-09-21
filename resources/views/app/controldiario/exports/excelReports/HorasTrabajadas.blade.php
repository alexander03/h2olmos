<table>
    @for ($r = 0; $r <= $max_row+1; $r++)
        @if ( isset($data[$r]) )
            <?php $row = $data[$r] ?>
            <tr>
                @for ($c = 0; $c <= $max_col+1; $c++)
                    @if ( isset($row[$c]) )
                        <?php $col = $row[$c] ?>
                        @if ( $col == $free_value )
                            <td></td>
                        @elseif ( is_array($col) )
                            <td 
                                @if (array_key_exists('rowspan', $col)) rowspan="{{ $col['rowspan'] }}" @endif 
                                @if (array_key_exists('colspan', $col)) colspan="{{ $col['colspan'] }}" @endif
                                >
                                @if (array_key_exists('value', $col)) {{ $col['value'] }} @endif
                            </td>
                        @endif
                    @endif
                @endfor
            </tr>
        @endif
    @endfor
</table>