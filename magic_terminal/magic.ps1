$code = @"
:loop
echo %random% %random% %random% %random%
goto loop
"@
Set-Content -Path matrix.bat -Value $code
Start-Process -NoNewWindow -FilePath "cmd.exe" -ArgumentList "/c matrix.bat"
