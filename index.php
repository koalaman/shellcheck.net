<html>
  <head>
    <title>ShellCheck &ndash; shell script analysis tool</title>
    <link rel="stylesheet" type="text/css" href="shellcheck.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:image" content="shellcheck.png" />
    <meta property="og:description" content="ShellCheck finds bugs in your shell scripts" />
    <meta name="description" content="ShellCheck is an open source static analysis tool that automatically finds bugs in your shell scripts." />
    <script src="bugreport.js"></script>
    <script src="shellcheck.js"></script>
    <script src="autofix.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  </head>
  <body>

<?php
  // Content to prepopulate the editor with
  $content = "";

  if ( isset($_GET["id"]) ) {
    $file = preg_replace("/[^a-zA-Z0-9]+/", "", $_GET["id"]);
    if ($file != "") {
      $content = file_get_contents("./data/$file");
    }
  }
?>

<div class="demo" style="display: none">#!/bin/sh
## Example: a typical script with several problems
for f in $(ls *.m3u)
do
  grep -qi hq.*mp3 $f \
    &amp;&amp; echo -e 'Playlist $f contains a HQ file in mp3 format'
done
</div>

<div class="demo" style="display: none">#!/bin/sh
## Example: The shebang says 'sh' so shellcheck warns about portability
##          Change it to '#!/bin/bash' to allow bashisms
for n in {1..$RANDOM}
do
  str=""
  if (( n % 3 == 0 ))
  then
    str="fizz"
  fi
  if [ $[n%5] == 0 ]
  then
    str="$strbuzz"
  fi
  if [[ ! $str ]]
  then
    str="$n"
  fi
  echo "$str"
done
</div>

<div class="demo" style="display: none">#!/bin/bash
## Example: ShellCheck can detect some higher level semantic problems

while getopts "nf:" param
do
  case "$param" in
    f) file="$OPTARG" ;;
    v) set -x ;;
  esac
done

case "$file" in
  *.gz) gzip -d "$file" ;;
  *.zip) unzip "$file" ;;
  *.tar.gz) tar xzf "$file" ;;
  *) echo "Unknown filetype" ;;
esac

if [[ "$$(uname)" == "Linux" ]]
then
  echo "Using Linux"
fi
</div>

<div class="demo" style="display: none">#!/bin/bash
## Example: ShellCheck can detect many different kinds of quoting issues

if ! grep -q backup=true.* "~/.myconfig"
then
  echo 'Backup not enabled in $HOME/.myconfig, exiting'
  exit 1
fi

if [[ $1 =~ "-v(erbose)?" ]]
then
  verbose='-printf "Copying %f\n"'
fi

find backups/ \
  -iname *.tar.gz \
  $verbose \
  -exec scp {}  “myhost:backups” +

</div>

    <div id="header">
      <div id="shellcheck">
      </div>
      <div id="github">
        <a href="https://github.com/koalaman/shellcheck">
          <img src="GitHub_Logo.png" style="height: 1.5ex" alt="GitHub" /> ➯
        </a>
      </div>
    </div>

    <div class="intro" style="display: none">
      <div class="banner">
        <div class="logo"> 
          <h1>ShellCheck</h1><br />
          finds&nbsp;bugs in your shell&nbsp;scripts.
        </div>
      </div>
    </div>
    <div class="contents">
      <div class="contentpart">
          <h1>ShellCheck</h1><br />
          finds&nbsp;bugs in your shell&nbsp;scripts.
      </div>

      <div class="contentpart">
        You can <code>cabal</code>, <code>apt</code>, <code>dnf</code>, <code>pkg</code>, <code>pacman</code> or <code>brew&nbsp;install</code> it locally right&nbsp;now.
      </div>

      <div class="contentpart">
        Paste a script to try it out:
      </div>

      <div class="contentpart">
        <div class="window" id="editorwindow">
          <div id="titlebar">
            <div class="titleitem">&#x1f4c4;</div>
            <div class="titleitem mainitem">Your Editor (<a href="https://github.com/ajaxorg/ace">Ace</a><span id="downloadingindicator"> &ndash; loading 800kb of JS</span>) </div>
            <a class="titleitem" href="javascript:minimize()">&#x25BC;</a>
            <div class="titleitem">&nbsp;</div>
            <a class="titleitem" href="javascript:maximize()">&#x25B2;</a>
          </div>
          <div class="windowbody">
            <div class="menubar">
              <a class="titleitem" href="#" onclick="editor.setValue(randomExample(), 1);">Load random example</a>
              <div class="titleitem mainitem"></div>
              <a id="autofix" class="titleitem miniitem disabledLink" href="javascript:applyAllFixes()">Apply fixes</a>
              <span class="titleitem spaceitem"></span>
              <a class="titleitem miniitem" href="javascript:reportBug()">Report bug</a>
              <span class="titleitem spaceitem"></span>
              <a class="titleitem miniitem" href="javascript:alert('Are you on mobile and unable to paste in the editor? Paste in this plaintext box to have it copied over.')">Mobile paste:</a>
              <div class="titleitem"><textarea id="pastehack" type="text" rows=1 cols=2 style="vertical-align: middle; display:inline; "></textarea></div><br />
            </div>
            <pre id="input"><?php echo htmlentities($content) ?></pre>
          </div>
        </div>
      </div>

      <div class="contentpart">
        <div class="window" id="terminalwindow">
          <div id="titlebar">
            <div class="titleitem">&#x1f4c4;</div>
            <div class="titleitem mainitem">
              ShellCheck Output
              <span id="processingindicator"></span>
            </div>
          </div>
          <div class="windowbody">
            <div id="terminal">
              If you paste a script in the editor above, this window will show shellcheck output.
            </div>
          </div>
        </div>
      </div>

      <div class="contentpart">
        <h2>ShellCheck is...</h2>
        <div class="benefitblock">
          <ul>
            <li><a href="https://github.com/koalaman/shellcheck/blob/master/LICENSE">GPLv3</a>: free as in freedom</li>
            <li>documented on the <a href="/wiki/Home">ShellCheck Wiki</a></li>
            <li>available on <a href="https://github.com/koalaman/shellcheck">GitHub</a> (as is <a href="https://github.com/koalaman/shellcheck.net">this website</a>)</li>
            <li>already packaged for your <a href="https://github.com/koalaman/shellcheck#user-content-installing">distro or package&nbsp;manager</a> </li>
            <li>supported as an <a href="https://github.com/koalaman/shellcheck#user-content-in-your-editor">integrated linter</a> in major&nbsp;editors</li>
            <li>available in <a href="https://codeclimate.com/">CodeClimate</a>, <a href="https://www.codacy.com/">Codacy</a> and <a href="https://www.codefactor.io/">CodeFactor</a> to auto-check your GitHub repo</li>
            <li>written in Haskell, if you're into that sort&nbsp;of&nbsp;thing.</li>
          </ul>
        </div>
      </div>
      <div class="contentpart">
        A special thanks to the <a href="https://github.com/sponsors/koalaman">GitHub Sponsors</a>:

        <a href="https://gitpod.io">Gitpod</a>
        &#8226; <a href="https://opensource.mercedes-benz.com/">Mercedes-Benz</a> <!-- mercedes-benz -->
        &#8226; <a href="https://www.bashsupport.com/pro/">BashSupport Pro</a> <!-- jansorg -->
        &#8226; <a href="https://route4me.com/">Route4Me</a>
        &#8226; <a href="https://github.com/siemens">Siemens</a>

        &#8226; <a href="https://github.com/per1234">per1234</a>
        &#8226; <a href="https://github.com/cavcrosby">cavcrosby</a>
        &#8226; <a href="https://github.com/dcminter">dcminter</a>
        &#8226; <a href="https://github.com/photostructure">photostructure</a>
        &#8226; <a href="https://cronitor.io">Cronitor</a>
        &#8226; <a href="https://github.com/djdefi">djdefi</a>
        &#8226; <a href="https://github.com/steve-chavez">steve-chavez</a>
        &#8226; <a href="https://github.com/ChrLau">ChrLau</a>
        &#8226; <a href="https://github.com/cjgibson">cjgibson</a>
        &#8226; <a href="https://celebian.com/">Celebian</a> <!-- celebiancom -->
        &#8226; <a href="https://www.llc.org/">LLC.org loves open source</a> <!-- llcorg -->
        &#8226; <a href="https://bestkru.com/">BestKru</a>
        &#8226; <a href="https://www.vpsserver.com/">VPSServer.com</a>
      </div>
    </div>
    <p style="display: none"><a href="/wiki/">Wiki Sitemap</a></p>
    <script src="libace/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
      var editor = ace.edit("input");
      editor.session.setMode("ace/mode/sh");
      editor.session.setOptions({"tabSize": 8, "useSoftTab": false});
      editor.setFontSize(12);
      editor.on("change", editorChangeHandler);

      $(document).ready(function() {
        $("#editorwindow").resizable({
          start: function(a,b) { $(this).css( {"max-width": "100%" }); },
          resize: function(a,b) { editor.resize(); },
          minWidth: 200,
          minHeight: 50,
        });
        $("#downloadingindicator").text("");

        $("#pastehack").on("change paste keyup", function() {
          if ( $("#pastehack").val() != "") {
            editor.setValue($("#pastehack").val());
            $("#pastehack").val("");
          }
        });
      });

      lastRandom = -1;
      function randomExample() {
        var candidates = $(".demo").toArray();
        var selection;
        do {
          selection = Math.floor(Math.random()*candidates.length);
        } while(selection === lastRandom);
        lastRandom = selection;
        return $(candidates[selection]).text();
      }
    </script>

  </body>
</html>
