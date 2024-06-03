import 'package:cloud_firestore/cloud_firestore.dart';

class FirebaseFirestoreService {
  final FirebaseFirestore _firestore = FirebaseFirestore.instance;

  Future<bool> addUser({
    required String userId,
    required String username,
    required String email,
    // Tambahkan parameter lain sesuai kebutuhan.
  }) async {
    try {
      await _firestore.collection('users').doc(userId).set({
        'username': username,
        'email': email,
        // Tambahkan data lain jika perlu.
      });
      print("BISA");
      return true; // Data berhasil disimpan
    } catch (e) {
      print('Error adding user to Firestore: $e');
      return false; // Data gagal disimpan
    }
  }

  // Tambahkan fungsi lain sesuai kebutuhan untuk membaca atau mengupdate data.
}
