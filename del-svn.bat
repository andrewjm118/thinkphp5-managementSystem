@echo on

@rem ɾ��SVN�汾����Ŀ¼

@rem for /r . %%a in (.) do @if exist "%%a\.svn" @echo "%%a\.svn"
@for /r . %%a in (.) do @if exist "%%a\.svn" rd /s /q "%%a\.svn"

@echo completed
@pause