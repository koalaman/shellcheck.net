var bugBaseUrl = "https://github.com/koalaman/shellcheck";

function makeReportUrl(script, json) {
  var template =
		"#### For bugs\n" +
		"- Rule Id (if any, e.g. SC1000): %ERRORS%\n" +
		"- My shellcheck version (`shellcheck --version` or 'online'): online\n" +
		"- [x] I tried on shellcheck.net and verified that this is still a problem on the latest commit\n" +
		"- [ ] It's not reproducible on shellcheck.net, but I think that's because it's an OS, configuration or encoding issue\n" +
		"\n" +
		"#### For new checks and feature suggestions\n" +
		"- [x] shellcheck.net (i.e. the latest commit) currently gives no useful warnings about this\n" +
		"- [ ] I searched through https://github.com/koalaman/shellcheck/issues and didn't find anything related\n" +
		"\n" +
		"\n" +
		"#### Here's a snippet or screenshot that shows the problem:\n" +
		"\n" +
		"```sh\n" +
		"%SCRIPT%\n" +
		"```\n" +
		"\n" +
		"#### Here's what shellcheck currently says:\n" +
		"```\n" +
		"%ACTUAL%\n" +
		"```\n" +
		"#### Here's what I wanted or expected to see:\n" +
		"\n" +
		"TODO: Describe expected/desired output\n" +
		"\n";

	var errors = json.map(function (x) { return "SC" + x.code; }).join(", ");
	var actual = json.map(function (x) {
				return "Line " + x.line +"\tSC" + x.code + ": " + x.message;
			}).join("\n");

  if (script == "") {
    script = "#!/your/shebang\nYour script";
    actual = "TODO: Describe current output";
  }

	var body = template
		.replace("%SCRIPT%", script)
		.replace("%ERRORS%", errors)
		.replace("%ACTUAL%", actual);

	return base + "/issues/new?body=" + encodeURIComponent(body);
}
