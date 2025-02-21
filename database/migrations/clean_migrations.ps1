Get-ChildItem -Path . -Filter *.php | Where-Object { $_.Name -ne '2025_02_18_180800_create_fresh_tables.php' } | Remove-Item
