// Substitui o bloco de tratamento de 422 que estava copiado em vários arquivos.

export function buildErrorMessages( error ) {
  if ( error?.status === 422 && error.data?.errors ) {
    return Object.values( error.data.errors )
      .flat()
      .map( message => `<p>${message}</p>` )
      .join( '' );
  }

  if ( error?.status === 401 ) return 'Credenciais inválidas';
  if ( error?.status === 403 ) return 'Sem permissão para esta ação.';
  if ( error?.status === 404 ) return 'Arquivo não encontrado.';
  if ( error?.status >= 500 ) return 'Erro no servidor. Tente novamente.';

  return 'Erro de rede';
}

// O fetch devolve a resposta; os arquivos costumam fazer "throw new Error(...)"
// quando !response.ok, e esse Error não carrega o status HTTP. Esta função monta
// um erro com status para o buildErrorMessages conseguir traduzir.
export function httpError( response, message = 'Falha na requisição' ) {
  const error = new Error( message );

  error.status = response.status;

  return error;
}
