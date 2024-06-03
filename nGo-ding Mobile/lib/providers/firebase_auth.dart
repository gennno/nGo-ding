import 'package:firebase_auth/firebase_auth.dart';
import 'package:google_sign_in/google_sign_in.dart';

class FirebaseAuthService {
  final FirebaseAuth _auth = FirebaseAuth.instance;

  Future<User?> signUpWithEmailAndPassword(String email, String password) async {
    
    try {
      UserCredential credential = await _auth.createUserWithEmailAndPassword(
          email: email, password: password);
      return credential.user;
      // Registrasi berhasil, lakukan navigasi ke halaman beranda atau beri tindakan sesuai kebutuhan.
    } catch (e) {
      print('Error during registration: $e');
      // Tampilkan pesan kesalahan kepada pengguna atau lakukan tindakan sesuai kebutuhan.
    }
    return null;
  }

  Future<User?> signInWithEmailAndPassword(String email, String password) async {
    
    try {
      UserCredential credential = await _auth.signInWithEmailAndPassword(
          email: email, password: password);
      return credential.user;
      // Registrasi berhasil, lakukan navigasi ke halaman beranda atau beri tindakan sesuai kebutuhan.
    } catch (e) {
      print('Error during Login: $e');
      // Tampilkan pesan kesalahan kepada pengguna atau lakukan tindakan sesuai kebutuhan.
    }
    return null;
  }

Future<UserCredential> signInWithGoogle() async {
  // Trigger the authentication flow
  final GoogleSignInAccount? googleUser = await GoogleSignIn().signIn();

  // Obtain the auth details from the request
  final GoogleSignInAuthentication? googleAuth = await googleUser?.authentication;

  // Create a new credential
  final credential = GoogleAuthProvider.credential(
    accessToken: googleAuth?.accessToken,
    idToken: googleAuth?.idToken,
  );

  // Once signed in, return the UserCredential
  return await FirebaseAuth.instance.signInWithCredential(credential);
}
}
