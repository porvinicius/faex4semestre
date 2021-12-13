<?php

namespace App\Utils;

class View {

    private static function getContentView(string $view)
    {
      $file = ROOT.'/views/'.$view.'.view.php';
      $content = file_exists($file) ? file_get_contents($file) : '';
      return self::hasInclude($content);

    }

    public static function render($view, array $vars = [])
    {
      $contentView = self::getContentView($view);
      $contentView = self::hasExtends($contentView);

      foreach ($vars as $key => $value) {
        $keyP = "#{{[ ]?((".$key.")([0-9a-zA-Z\[\]\->()]+)?)[ ]?}}#im";

        preg_match_all($keyP, $contentView, $matchs);


        foreach($matchs[0] as $index => $match) {
          if (array_key_exists(3, $matchs) && !empty($matchs[3][$index])) {
            $str = '$vars[$key]'.$matchs[3][$index].';';
            $value = eval("return ".$str);
            $match = str_replace('[', '\[', $match);
            $match = str_replace(']', '\]', $match);
            $contentView = preg_replace("#".$match."#im", (string)$value, $contentView);
          } else {

            $contentView = preg_replace($keyP, (string)$value, $contentView);
          }

        }
      }
      $contentView = self::hasFor($contentView, $vars);


      $contentView = self::hasIf($contentView);

      return preg_replace( '#{[%{][ ]?([\s\S]*?)[%}][ ]?}#mi','',$contentView);
    }

    public static function include($way)
    {
        return self::getContentView($way);
    }

    private static function hasExtends($content)
    {
      preg_match_all('#{%[ ]?extends ([^\s]+?)[ ]?%}#i', $content, $matches);

      if (empty($matches[1])) {
          return $content;
      }

      $extend = implode(' ', $matches[1]);


      $contentExtend = self::getContentView($extend);



      $regex1 = "#{%[ ]?block ([\w]+)[ ]?%}(([\s\S]*?)*?|){%[ ]?endblock[ ]?%}#im";
        //{%[. block]+ ([^\s]+).%}


      preg_match_all($regex1, $content, $matchesBlock);

      if (empty($matchesBlock[1])) {
          return $contentExtend;
      }

      $keysBlock = $matchesBlock[1];

      $valueBlock = $matchesBlock[2];

      $arr = array_combine($keysBlock , $valueBlock);

      foreach ($arr as $key => $value) {
          $regex = "#{%[ ]?block (".$key.")[ ]?%}(([\s\S]*?)*?|){%[ ]?endblock[ ]?%}#im";
          $contentExtend = preg_replace($regex, htmlspecialchars_decode($value), $contentExtend);
      }
      return $contentExtend;
    }

    private static function hasInclude($content)
    {
        preg_match_all("#{%[ ]?include ([\S]*?)[ ]?%}#i", $content, $matchs);

        if (empty($matchs[1])) {
            return $content;
        }

        foreach ($matchs[1] as $match) {
          $contentInclude = self::getContentView($match);
          $content = preg_replace("#{%[ ]?include ($match)[ ]?%}#i", $contentInclude, $content);
        }

        return $content;
    }

  private static function hasFor($content, $vars)
  {
    preg_match_all("#{%[ ]?for ([\s\S]+?) ([\s\S]+?)[ ]?%}([\s\S]+?){%[ ]?endfor[ ]?%}#i", $content, $matchs);

    foreach ($matchs[2] as $index => $match) {
      $contentMatch = $matchs[3][$index];
      $turn = $matchs[1][$index];
      $var = $matchs[2][$index];
      $var = trim($var);
      $content = preg_replace("#{%[ ]?for ([\s\S]+?) ".$var."[ ]?%}([\s\S]+?){%[ ]?endfor[ ]?%}#i", "{% for$var %}", $content);
      $contentFor = '';

      for ($i = 0; $i < (int)$turn; $i++) {
        $contentMatchVar = $contentMatch;
        foreach ($vars as $key => $value) {
          $keyP = "#{\\$[ ]?((".$key.")([0-9a-zA-Z\[\]\->()_'\"]+)?)[ ]?\\$}#im";

          preg_match_all($keyP, $contentMatch, $matchsVV);

          if (!empty($matchsVV)) {
            foreach ($matchsVV[1] as $keyVVV => $matchVVV) {
              if (array_key_exists(3, $matchsVV)) {
                $str = str_replace($var, $i,'$vars[$key]'.$matchsVV[3][$keyVVV].';');
                $value = eval("return ".$str);
              }

              $matchPp = str_replace('[', '\[', $matchVVV);
              $matchPp = str_replace(']', '\]', $matchPp);
              $keyPp = "#{\\$[ ]?".$matchPp."[ ]?\\$}#im";

              $contentMatchVar = preg_replace($keyPp, (string)$value, $contentMatchVar);

            }
          }
            $contentMatchVar = preg_replace($keyP, (string)$value, $contentMatchVar);
        }

        $contentFor .= $contentMatchVar;
      }
      $content = preg_replace("#{%[ ]?for".$var."[ ]?%}#i", $contentFor, $content);
    }

    return $content;
  }

  private static function hasIf($content)
  {
    preg_match_all("#{%[ ]?if ([\s\S]+?) ([\s\S]+?)? ([\s\S]+?)?[ ]?%}([\s\S]+?){%[ ]?endif[ ]?%}#i", $content, $matchs);


    foreach($matchs[0] as $index => $match) {
      $val1 = $matchs[1][$index];
      $val2 = $matchs[3][$index];
      $signal = $matchs[2][$index];
      $contentIf = $matchs[4][$index];
      $ev = 'return '.$val1.' '.$signal.' '.$val2.';';
      $result = eval($ev);


      if ($result) {
        $content = str_replace($match, $contentIf, $content);
      } else {
        $content = str_replace($match, '', $content);
      }
    }

    return $content;
  }
}