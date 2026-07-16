<!-- calltouch -->
    <script>
        (function (w, d, n, c) {
            w.CalltouchDataObject = n;
            w[n] = function () {
                w[n]["callbacks"].push(arguments)
            };
            if (!w[n]["callbacks"]) {
                w[n]["callbacks"] = []
            }
            w[n]["loaded"] = false;
            if (typeof c !== "object") {
                c = [c]
            }
            w[n]["counters"] = c;
            for (var i = 0; i < c.length; i += 1) {
                p(c[i])
            }

            function p(cId) {
                var a = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    i = function () {
                        a.parentNode.insertBefore(s, a)
                    };
                s.async = true;
                s.src = "https://mod.calltouch.ru/init.js?id=" + cId;
                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", i, false)
                } else {
                    i()
                }
            }
        })(window, document, "ct", "9500f011");
    </script>
<!--calltouch -->