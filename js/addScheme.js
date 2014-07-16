function addScheme(url, scheme) {
  scheme = typeof scheme !== 'undefined' ? scheme : 'http://'; // Default
  if (url.length == 0 || url.match(/^(https?|ftp|tel|mailto)/i)) {
    return url;
  }
  return scheme + url;
}
