<html>
  <head>
    <title>ShellCheck &ndash; shell script analysis tool</title>
    <link rel="stylesheet" type="text/css" href="shellcheck.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="shellcheck.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  </head>
  <body>

<div id="demo" style="display: none">#!/bin/sh
## Example of a broken script.
for f in $(ls *.m3u)
do
  grep -qi hq.*mp3 $f \
    &amp;&amp; echo -e 'Playlist $f contains a HQ file in mp3 format' 
done
</div>

    <div id="header">
      <div id="shellcheck">
      </div>
      <div id="github">
        <a href="https://github.com/koalaman/shellcheck">
          <img src="https://assets-cdn.github.com/images/modules/logos_page/GitHub-Logo.png" style="height: 1.5ex" alt="GitHub" /> ➯
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
        You can <code>cabal</code>, <code>apt-get</code>, <code>yum</code> or <code>brew&nbsp;install</code> it locally right&nbsp;now.
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
              <a class="titleitem" href="#" onclick="editor.setValue($('#demo').text(), 1);">Load an example</a>
              <div class="titleitem mainitem"></div>
              <div class="titleitem"><textarea id="pastehack" type="text" rows=1 cols=2 style="vertical-align: middle; display:inline; "></textarea><a href="javascript:alert('Are you on mobile and unable to paste in the editor? Paste in this plaintext box to have it copied over.')">(?)</a></div><br />
            </div>
            <pre id="input"></pre>
          </div>
        </div>
      </div>

      <div class="contentpart">
        <div class="window" id="terminalwindow">
          <div id="titlebar">
            <div class="titleitem">&#x1f4c4;</div>
            <div class="titleitem mainitem">
              Your Terminal
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

<script>
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
</script>

      <div class="contentpart">
        <h2>ShellCheck is...</h2>
        <div class="benefitblock">
          <ul>
            <li><a href="https://github.com/koalaman/shellcheck/blob/master/LICENSE">GPLv3</a>: free as in freedom</li>
            <li>available on <a href="https://github.com/koalaman/shellcheck">GitHub</a></li>
            <li>already packaged for your <a href="https://github.com/koalaman/shellcheck#user-content-installing">distro or package&nbsp;manager</a> </li>
            <li>supported as an <a href="https://github.com/koalaman/shellcheck#user-content-in-your-editor">integrated linter</a> in major&nbsp;editors</li>
            <li>available in <a href="https://codeclimate.com/">CodeClimate</a> and <a href="https://www.codacy.com/">Codacy</a> to auto-check your GitHub repo</li>
            <li>written in Haskell, if you're into that sort&nbsp;of&nbsp;thing.</li>
          </ul>
        </div>
      </div>
      <div class="contentpart">
        Sounds awesome? <a href="https://github.com/koalaman/shellcheck">Read more about it</a> on the <a href="https://github.com/koalaman/shellcheck">GitHub page</a>!
    </div>
    <script src="libace/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
      var editor = ace.edit("input");
      editor.session.setMode("ace/mode/sh");
      editor.session.setOptions({"tabSize": 8});
      editor.setFontSize(12);
      editor.on("change", editorChangeHandler);
    </script>
  </body>
</html>
