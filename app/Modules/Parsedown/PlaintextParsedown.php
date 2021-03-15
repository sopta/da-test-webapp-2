<?php

namespace CzechitasApp\Modules\Parsedown;

class PlaintextParsedown extends \Parsedown
{
    protected function mb_str_pad(
        $input,
        $pad_length,
        $pad_string = ' ',
        $pad_style = STR_PAD_RIGHT,
        $encoding = 'UTF-8'
    ) {
        return str_pad(
            $input,
            strlen($input) - mb_strlen($input, $encoding) + $pad_length,
            $pad_string,
            $pad_style
        );
    }

    protected function element(array $Element, $block = null)
    {
        if ($this->safeMode) {
            $Element = $this->sanitiseElement($Element);
        }

        if ($Element['name'] == 'a') {
            return $Element['attributes']['href'];
        }

        if ($Element['name'] == 'img') {
            if (!empty($Element['attributes']['title'])) {
                return '(' . $Element['attributes']['title'] . ')';
            }
            if (!empty($Element['attributes']['alt'])) {
                return '(' . $Element['attributes']['alt'] . ')';
            }
            return '';
        }

        if ($Element['name'] == 'table' && !empty($block)) {
            return $this->processTable($block);
        }

        $markup = '';
        if (isset($Element['text'])) {
            if (!isset($Element['nonNestables'])) {
                $Element['nonNestables'] = [];
            }
            if (isset($Element['handler'])) {
                $markup .= $this->{$Element['handler']}($Element['text'], $Element['nonNestables']);
            } else {
                $markup .= self::escape($Element['text'], true);
            }
        }
        return $markup;
    }

    protected function processTable($table)
    {
        $element = $table['element'];
        $alignments = $table['alignments'];

        $columns = count($alignments);
        $columnsWidth = array_fill(0, $columns, 0);
        $data = array_fill(0, $columns, []);

        // Save to array and count max lengths of text in each column
        $r = 0;
        for ($i = 0; $i < count($element['text']); $i++) {
            foreach ($element['text'][$i]['text'] as $row) {
                $c = 0;
                foreach ($row['text'] as $column) {
                    $data[$c][$r]       = $this->line($column['text']);
                    $columnsWidth[$c]   = max($columnsWidth[$c], mb_strlen($data[$c][$r]));
                    $c++;
                }
                // Fill empty cell missing in row
                for (; $c < $columns; $c++) {
                    $data[$c][$r] = '';
                }
                $r++;
            }
        }

        $strpadType = [
            'left'      => STR_PAD_RIGHT,
            'center'    => STR_PAD_BOTH,
            'right'     => STR_PAD_LEFT,
        ];

        $markup = '';

        // Build table
        for ($r = 0; $r < count($data[0]); $r++) {
            for ($c = 0; $c < $columns; $c++) {
                $cell = $this->mb_str_pad(
                    $data[$c][$r],
                    $columnsWidth[$c],
                    ' ',
                    ($alignments[$c] == null ? STR_PAD_RIGHT : $strpadType[$alignments[$c]])
                );

                $markup .= "| {$cell} ";
                if ($c == $columns - 1) {
                    $markup .= '|';
                }
            }
            $markup .= "\n";
            // Line after heading
            if ($r == 0) {
                $lineLength = array_sum($columnsWidth) + 3 * $columns - 1;
                $markup .= '|' . $this->mb_str_pad('', $lineLength, '-') . "|\n";
            }
        }

        return $markup;
    }

    protected function lines(array $lines)
    {
        $CurrentBlock = null;

        foreach ($lines as $line) {
            if (chop($line) === '') {
                if (isset($CurrentBlock)) {
                    $CurrentBlock['interrupted'] = true;
                }

                continue;
            }

            if (strpos($line, "\t") !== false) {
                $parts = explode("\t", $line);

                $line = $parts[0];

                unset($parts[0]);

                foreach ($parts as $part) {
                    $shortage = 4 - mb_strlen($line, 'utf-8') % 4;

                    $line .= str_repeat(' ', $shortage);
                    $line .= $part;
                }
            }

            $indent = 0;

            while (isset($line[$indent]) && $line[$indent] === ' ') {
                $indent++;
            }

            $text = $indent > 0 ? substr($line, $indent) : $line;

            // ~

            $Line = ['body' => $line, 'indent' => $indent, 'text' => $text];

            // ~

            if (isset($CurrentBlock['continuable'])) {
                $Block = $this->{'block' . $CurrentBlock['type'] . 'Continue'}($Line, $CurrentBlock);

                if (isset($Block)) {
                    $CurrentBlock = $Block;

                    continue;
                } else {
                    if ($this->isBlockCompletable($CurrentBlock['type'])) {
                        $CurrentBlock = $this->{'block' . $CurrentBlock['type'] . 'Complete'}($CurrentBlock);
                    }
                }
            }

            // ~

            $marker = $text[0];

            // ~

            $blockTypes = $this->unmarkedBlockTypes;

            if (isset($this->BlockTypes[$marker])) {
                foreach ($this->BlockTypes[$marker] as $blockType) {
                    $blockTypes[] = $blockType;
                }
            }

            // ~

            foreach ($blockTypes as $blockType) {
                $Block = $this->{'block' . $blockType}($Line, $CurrentBlock);

                if (isset($Block)) {
                    $Block['type'] = $blockType;

                    if (! isset($Block['identified'])) {
                        $Blocks[] = $CurrentBlock;

                        $Block['identified'] = true;
                    }

                    if ($this->isBlockContinuable($blockType)) {
                        $Block['continuable'] = true;
                    }

                    $CurrentBlock = $Block;

                    continue 2;
                }
            }

            // ~

            if (isset($CurrentBlock) && ! isset($CurrentBlock['type']) && ! isset($CurrentBlock['interrupted'])) {
                $CurrentBlock['element']['text'] .= "\n" . $text;
            } else {
                $Blocks[] = $CurrentBlock;

                $CurrentBlock = $this->paragraph($Line);

                $CurrentBlock['identified'] = true;
            }
        }

        // ~

        if (isset($CurrentBlock['continuable']) && $this->isBlockCompletable($CurrentBlock['type'])) {
            $CurrentBlock = $this->{'block' . $CurrentBlock['type'] . 'Complete'}($CurrentBlock);
        }

        // ~

        $Blocks[] = $CurrentBlock;

        unset($Blocks[0]);

        // ~

        $markup = '';

        foreach ($Blocks as $Block) {
            if (isset($Block['hidden'])) {
                continue;
            }

            $markup .= "\n";
            $markup .= isset($Block['markup']) ? $Block['markup'] : $this->element($Block['element'], $Block);
        }

        $markup .= "\n";

        // ~

        return $markup;
    }
}
