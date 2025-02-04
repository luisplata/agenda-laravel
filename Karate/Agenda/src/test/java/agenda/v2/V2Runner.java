package agenda.v2;

import com.intuit.karate.junit5.Karate;

public class V2Runner {

    @Karate.Test
    Karate testAll() {
        return Karate.run("src/test/java/agenda/v2/");
    }
}
