// helpers/validators.js
// Validações de formulário. 
// tava bemmm confuso antes


export function isValidEmail( email ) {
  if ( email.includes( ' ' ) ) return false;

  const parts = email.split( '@' );
  if ( parts.length !== 2 ) return false;

  const [ user, domain ] = parts;
  if ( !user ) return false;

  const domainParts = domain.split( '.' );
  if ( domainParts.length < 2 ) return false;
  if ( domainParts.some( part => !part ) ) return false;

  return true;
}

// Retorna a lista de mensagens de erro; lista vazia significa que está tudo certo.
export function validateLogin( { email, password } ) {
  const errors = [];

  const trimmedEmail = ( email ?? '' ).trim();
  if ( !trimmedEmail ) errors.push( 'Informe o e-mail.' );
  else if ( !isValidEmail( trimmedEmail ) ) errors.push( 'E-mail inválido.' );

  // No login só exige que a senha esteja preenchida, não o tamanho mínimo
  if ( !password ) errors.push( 'Informe a senha.' );

  return errors;
}

export function validateRegister( { name, email, password, password_confirmation, gender } ) {
  const errors = [];

  const trimmedName = ( name ?? '' ).trim();
  if ( !trimmedName ) errors.push( 'Informe o nome.' );
  else if ( trimmedName.length > 150 ) errors.push( 'O nome deve ter no máximo 150 caracteres.' );

  const trimmedEmail = ( email ?? '' ).trim();
  if ( !trimmedEmail ) errors.push( 'Informe o e-mail.' );
  else if ( !isValidEmail( trimmedEmail ) ) errors.push( 'E-mail inválido.' );

  if ( !password ) errors.push( 'Informe a senha.' );
  else if ( password.length < 8 ) errors.push( 'A senha deve ter no mínimo 8 caracteres.' );

  if ( password !== password_confirmation ) errors.push( 'As senhas não conferem.' );

  // "other" virou null no submit, então só valida se chegou algum valor
  if ( gender && ![ 'man', 'woman' ].includes( gender ) ) errors.push( 'Gênero inválido.' );

  return errors;
}

const GENDERS = [ 'man', 'woman' ];
const WRITING_LEVELS = [ 'pre-silabico', 'silabico', 'silabico-alfabetico', 'alfabetico' ];

export function validateStudent( { classroom, name, date, genre, writing_level } ) {
  const errors = [];

  if ( !classroom ) errors.push( 'Informe a turma.' );

  const trimmedName = ( name ?? '' ).trim();
  if ( !trimmedName ) errors.push( 'Informe o nome.' );
  else if ( trimmedName.length > 150 ) errors.push( 'O nome deve ter no máximo 150 caracteres.' );

  if ( !date ) errors.push( 'Informe a data de nascimento.' );
  else {
    const birth = new Date( date + 'T00:00:00' );

    // O aluno precisa ter mais de 4 anos (o backend exige data anterior a hoje menos 4 anos)
    const limit = new Date();
    limit.setHours( 0, 0, 0, 0 );
    limit.setFullYear( limit.getFullYear() - 4 );

    if ( Number.isNaN( birth.getTime() ) ) errors.push( 'Data de nascimento inválida.' );
    else if ( birth >= limit ) errors.push( 'O aluno deve ter mais de 4 anos.' );
  }

  // Sexo "Outro" tem value vazio e o nível de escrita é opcional
  if ( genre && !GENDERS.includes( genre ) ) errors.push( 'Sexo inválido.' );
  if ( writing_level && !WRITING_LEVELS.includes( writing_level ) ) errors.push( 'Nível de escrita inválido.' );

  return errors;
}
