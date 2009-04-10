property baseURL : "http://jeremyhubert.com/playground/mvs/?song="

tell application "iTunes"
  
  -- get a reference to playing or selected track
  if player state is not stopped then
    set theTrack to current track
  else if selection is not {} then
    set theTrack to (item 1 of selection)
  else
    display dialog "Nothing is playing or selected." buttons {"Cancel"} ¬
      default button 1 with icon 0
  end if
  
  -- get the name and artist and replace "bad" characters
  tell theTrack
    set title to my fixChars(name)
    set art to my fixChars(artist)
  end tell
  
  -- assemble URL string, replace spaces with "+"
  set theURL to (baseURL & ¬
    (my replace_chars((art & " " & title), " ", "+"))) as text
  
  my open_location(theURL)
  
end tell

on fixChars(a)
  set myDelims to {"!", "@", "#", "$", "%", "^", "&", "*", ¬
    "(", ")", "-", "-", "+", "=", ":", ";", "'", ",", ".", "/", ¬
    "<", ">", "?", "{", "}", "[", "]"}
  repeat with curDelim in myDelims
    set AppleScript's text item delimiters to curDelim
    set s to every text item of a
    set AppleScript's text item delimiters to {""}
    set a to s as string
  end repeat
  return a
end fixChars

on replace_chars(txt, srch, repl)
  set AppleScript's text item delimiters to the srch
  set the item_list to every text item of txt
  set AppleScript's text item delimiters to the repl
  set txt to the item_list as string
  set AppleScript's text item delimiters to ""
  return txt
end replace_chars

to open_location(theURL)
  tell application "Safari"
    activate
    if name of window 1 does not contain "Illanti MVS:" then
      make new document at end of documents
    end if
    set URL of document 1 to theURL
  end tell
end open_location