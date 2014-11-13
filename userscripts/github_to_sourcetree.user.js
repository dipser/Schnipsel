// ==UserScript==
// @name        Github to Sourcetree
// @namespace   ghtst
// @description Fügt einen Button zu Github hinzu, um ein Repository in SourceTree zu klonen.
// @include     https://*github.com/*
// @version     1
// @grant       none
// ==/UserScript==


(function(){
    const $ = document.querySelectorAll.bind(document);
    
    //GitHub's "Clone in Desktop" Button
    const gitHubNode = $(".clone-options + a")[0]
    const parentNode = gitHubNode.parentNode;
    //Insert our button between the GitHub Clone button and whatever is after it.
    const insertBeforeNode = gitHubNode.nextSibling;
    //Find the clone url for this repo
    const gitURL = $(".js-url-field")[0].value
    
    var sourceTreeNode = gitHubNode.cloneNode();
    sourceTreeNode.href = 'sourcetree://cloneRepo/' + gitURL;
    sourceTreeNode.innerHTML = '<img style="margin-bottom:-3px;" width="16" height="16" title="" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAB1WlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyI+CiAgICAgICAgIDx0aWZmOkNvbXByZXNzaW9uPjE8L3RpZmY6Q29tcHJlc3Npb24+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgICAgIDx0aWZmOlBob3RvbWV0cmljSW50ZXJwcmV0YXRpb24+MjwvdGlmZjpQaG90b21ldHJpY0ludGVycHJldGF0aW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KAtiABQAAA0NJREFUOBFdkk1sW0UQx/+7+/z8iLErx3ET4joVwUGKAiRqEudSUaGqUntEEKlXVJAqQFBK+TghDgiQGg4JauHQ8qHypXIAia8DcChBNIodSIvS0OTRtCaNKR9u8hzHL+/tB7tWLUWsNNrZ2fnNzswOsGWNjo6y5nFwcDCSz+dTRozetG/1MTbSvNA71SKHh4e7GWNPQKm9ilkZEAIi+HV99b0Q6kShULjS9DVsM0ADHhoaOkQoG2e2E5M8gPL+hPKroO09oMyC2PRrSqmni8Xi6WYQeislOTAw8Chh7BSvVWL+wrkwLM9Iuf+owlMfqeDSeemXLoRCyhgh9JTx1QGkYRsZ9PX15eyoc0HWV1us3ge4ff/DVu3IftjHToBmeiAXCrDu7kd94jFOkp0WlNwIg6B/bm7ONalD1/ykIrQlXPw9EFJY0Z09iB5+BWKxCF74GrAiiGxLIyyVLc5NbarFMIal+nVb6oaF66twRh+3AreI8oN3wc50gyTaEM/vw23tGXifTqDz3Slse+iI5c/OQln2XsPSGtAqBN/B6wGyjzxPss+8CZFOIkIFoqk2MAjc+OB1VL/5EJaSCEqXiUgAPAh21Gq1Vio8jwouiXKiuPziQazPz+DO597C8sfjaL03j+DaJdjpDvSMf47K5JeofDEB2tkLvlknQghqmujkcrmfdXd7RX1NVpZv0Pxr74Ov/YPN1X9hb88icnsCf8+c06//Bv+v65Lqpb9z3nXdXaaJPhdiUkGBcyZ2v/o2bl78EeVfptCZ34OWRByk7iGe7cKe8U+gmCPMjAilJg3b+AX9JSd1Ojxcr0c6+neJ+w4eQrItCfezd9DencNayQXZqKEyOy28hbmIsqI88P2TOkBjEs38i0w2+6xFyNhGqaRoZiffffRlRqkuTE9gUF1VkXhS/Hr2tFWdLxKSSB37Y2npDc0xAysTqOp5P8VisQ2nvWNf5doVlsx2kbZMlsSSrWTxh+/I1NhLLLxZBktuf2F5aWnMMFpkowStmEVWVlaOs2hspA6ccRznqp5+f7kw6U+ffe9q+p7+MzTdNaLh48a3QWxVbhka5Rh95MCBhJVK3RGPpzD97Vfliut6//cx5/8AfOJ0qQTwb1kAAAAASUVORK5CYII=" />'
       //+'<span class="octicon octicon-device-desktop"></span>'
       +' Clone in SourceTree';
    
    parentNode.insertBefore(sourceTreeNode, insertBeforeNode);
})()
